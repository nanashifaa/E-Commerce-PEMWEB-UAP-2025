<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class WithdrawalController extends Controller
{
    public function index()
    {
        $store = auth()->user()->store;

        $balance = $store->storeBalance()->firstOrCreate(
            ['store_id' => $store->id],
            ['balance' => 0]
        );

        $totalIncome = $balance->storeBalanceHistories()
            ->where('type', 'income')
            ->sum('amount');

        $totalWithdrawals = $balance->storeBalanceHistories()
            ->where('type', 'withdraw')
            ->sum('amount');

        $computedBalance = $totalIncome - $totalWithdrawals;

        $withdrawals = $balance->withdrawals()->latest()->get();

        return view('seller.withdrawals', compact(
            'balance',
            'withdrawals',
            'totalIncome',
            'totalWithdrawals',
            'computedBalance'
        ));
    }

    public function store(Request $request)
    {
        $request->validate([
            'amount' => 'required|numeric|min:10000',
            'bank_name' => 'required|string',
            'account_number' => 'required|string',
            'account_name' => 'required|string',
        ]);

        $store = auth()->user()->store;

        $balance = $store->storeBalance()->firstOrCreate(
            ['store_id' => $store->id],
            ['balance' => 0]
        );

        if ($balance->balance < $request->amount) {
            return back()->with('error', 'Insufficient balance!');
        }

        \DB::transaction(function () use ($balance, $request) {

            // 🔻 Kurangi saldo toko
            $balance->decrement('balance', $request->amount);

            // 🔻 Buat history sementara
            $history = $balance->storeBalanceHistories()->create([
                'type'           => 'withdraw',
                'amount'         => $request->amount,
                'remarks'        => "Withdrawal request",
                'reference_type' => 'withdrawal',
                'reference_id'   => 0,
            ]);

            // 🔻 Buat withdrawal request
            $withdraw = $balance->withdrawals()->create([
                'amount' => $request->amount,
                'bank_account_number' => $request->account_number,
                'bank_account_name' => $request->account_name,
                'bank_name' => $request->bank_name,
                'status' => 'pending',
            ]);

            // 🔻 Perbarui reference ID
            $history->update(['reference_id' => $withdraw->id]);
        });

        return back()->with('success', 'Withdrawal request submitted successfully!');
    }
}
