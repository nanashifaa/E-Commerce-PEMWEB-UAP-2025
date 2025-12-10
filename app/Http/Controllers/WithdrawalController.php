<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class WithdrawalController extends Controller
{
    public function index()
    {
        $store = auth()->user()->store;
        
        // Get balance
        $balance = $store->storeBalance()->firstOrCreate([], ['balance' => 0]);
        
        // Get withdrawals history
        $withdrawals = $store->storeBalance->withdrawals()->latest()->get();

        return view('seller.withdrawals', compact('balance', 'withdrawals'));
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
        $balance = $store->storeBalance()->firstOrCreate([], ['balance' => 0]);

        if ($balance->balance < $request->amount) {
            return back()->with('error', 'Insufficient balance!');
        }

        \Illuminate\Support\Facades\DB::transaction(function () use ($balance, $request) {
            // Deduct balance
            $balance->decrement('balance', $request->amount);

            // Create history
            $balance->storeBalanceHistories()->create([
                'type' => 'debit', // Out
                'amount' => $request->amount,
                'remarks' => 'Withdrawal Request to ' . $request->bank_name . ' (' . $request->account_number . ') ' . $request->account_name,
                'reference_type' => 'withdrawal',
                'reference_id' => 0 // Temporary
            ]);

            // Create withdrawal request
            $withdrawal = $balance->withdrawals()->create([
                'amount' => $request->amount,
                'bank_name' => $request->bank_name,
                'bank_account_number' => $request->account_number,
                'bank_account_name' => $request->account_name,
                'status' => 'pending'
            ]);
            
            // Update reference in history
            $balance->storeBalanceHistories()->latest()->first()->update(['reference_id' => $withdrawal->id]);
        });

        return back()->with('success', 'Withdrawal request submitted successfully!');
    }
}
