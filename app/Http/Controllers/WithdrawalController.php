<?php

namespace App\Http\Controllers;

use App\Models\StoreBalance;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class WithdrawalController extends Controller
{
    public function index()
    {
        $store = auth()->user()->store;

        $balance = $store->storeBalance()->firstOrCreate(
            ['store_id' => $store->id],
            ['balance' => 0]
        );

        $withdrawals = $balance->withdrawals()->latest()->get();

        $pendingAmount = (int) $balance->withdrawals()
            ->where('status', 'pending')
            ->sum('amount');

        $approvedAmount = (int) $balance->withdrawals()
            ->where('status', 'approved')
            ->sum('amount');

        $availableBalance = (int) $balance->balance;

        // ✅ TOTAL PEMASUKAN (DARI RIWAYAT TRANSAKSI)
        $totalIncome = 0;
        if (method_exists($balance, 'storeBalanceHistories')) {
            $totalIncome = (int) $balance->storeBalanceHistories()
                ->where('type', 'income')
                ->sum('amount');
        }

        // saldo asli sebelum lock pending
        $computedBalance = $availableBalance + $pendingAmount;

        // semua penarikan tercatat
        $totalWithdrawals = (int) $balance->withdrawals()->sum('amount');

        return view('seller.withdrawals', compact(
            'balance',
            'withdrawals',
            'availableBalance',
            'pendingAmount',
            'approvedAmount',
            'computedBalance',
            'totalIncome',
            'totalWithdrawals'
        ));
    }

    public function store(Request $request)
    {
        $request->validate([
            'amount' => 'required|numeric|min:10000',
            'bank_name' => 'required|string|max:255',
            'account_number' => 'required|string|max:255',
            'account_name' => 'required|string|max:255',
        ]);

        $store = auth()->user()->store;

        DB::transaction(function () use ($store, $request) {

            /** @var StoreBalance $balance */
            $balance = StoreBalance::where('store_id', $store->id)
                ->lockForUpdate()
                ->first();

            if (!$balance) {
                $balance = StoreBalance::create([
                    'store_id' => $store->id,
                    'balance' => 0
                ]);
                // lock lagi kalau baru dibuat
                $balance = StoreBalance::where('id', $balance->id)->lockForUpdate()->first();
            }

            if ($balance->balance < $request->amount) {
                abort(422, 'Insufficient balance!');
            }

            // 1) Lock saldo (langsung berkurang)
            $balance->decrement('balance', $request->amount);

            // 2) Create withdrawal pending
            $withdraw = $balance->withdrawals()->create([
                'amount'              => $request->amount,
                'bank_account_number' => $request->account_number,
                'bank_account_name'   => $request->account_name,
                'bank_name'           => $request->bank_name,
                'status'              => 'pending',
            ]);

            // 3) Optional: create history (kalau tabel histories kamu ada)
            if (method_exists($balance, 'storeBalanceHistories')) {
                $balance->storeBalanceHistories()->create([
                    'type'           => 'withdraw',
                    'amount'         => $request->amount,
                    'remarks'        => 'Withdrawal request (pending)',
                    'reference_type' => 'withdrawal',
                    'reference_id'   => $withdraw->id,
                ]);
            }
        });

        return back()->with('success', 'Withdrawal request submitted successfully!');
    }
}
