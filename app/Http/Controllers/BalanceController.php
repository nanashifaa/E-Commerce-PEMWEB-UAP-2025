<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class BalanceController extends Controller
{
    public function index()
    {
        $store = auth()->user()->store;

        // Auto create balance if not exists (defensive programming)
        $balance = \App\Models\StoreBalance::firstOrCreate(
            ['store_id' => $store->id],
            ['balance' => 0]
        );

        $histories = $balance->storeBalanceHistories()->latest()->take(10)->get();

        return view('seller.balance', compact('store', 'balance', 'histories'));
    }
}
