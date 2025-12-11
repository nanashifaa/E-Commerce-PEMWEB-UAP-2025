<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class WithdrawalController extends Controller
{
    public function index()
    {
        $store = auth()->user()->store;

        // Ambil / buat saldo toko
        $balance = $store->storeBalance()->firstOrCreate(['store_id' => $store->id], ['balance' => 0]);

        // Total income dari history
        $totalIncome = $balance->storeBalanceHistories()
            ->where('type', 'income')
            ->sum('amount');

        // Total withdrawal / debit
        $totalWithdrawals = $balance->storeBalanceHistories()
            ->whereIn('type', ['debit', 'withdraw'])
            ->sum('amount');

        // Saldo akhir berdasarkan perhitungan
        $computedBalance = $totalIncome - $totalWithdrawals;

        // Riwayat withdrawal
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
            'bank_name' => 'required',
            'account_number' => 'required',
            'account_name' => 'required',
        ]);

        $store = auth()->user()->store;
        $balance = $store->storeBalance()->firstOrCreate([], ['balance' => 0]);

        if ($balance->balance < $request->amount) {
            return back()->with('error', 'Insufficient balance!');
        }

        \DB::transaction(function () use ($balance, $request) {

            $balance->decrement('balance', $request->amount);

            $history = $balance->storeBalanceHistories()->create([
                'type' => 'debit',
                'amount' => $request->amount,
                'remarks' => "Withdrawal request",
            ]);

            $withdraw = $balance->withdrawals()->create([
                'amount' => $request->amount,
                'bank_account_number' => $request->account_number,
                'bank_account_name' => $request->account_name,
                'bank_name' => $request->bank_name,
                'status' => 'pending'
            ]);

            $history->update(['reference_id' => $withdraw->id]);
        });

        return back()->with('success', 'Withdrawal request submitted!');
    }
}
