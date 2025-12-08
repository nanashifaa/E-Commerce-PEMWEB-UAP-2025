<?php

namespace App\Http\Controllers;

use App\Models\Transaction;
use Illuminate\Http\Request;

class TransactionHistoryController extends Controller
{
    public function index()
    {
        // Ambil transaksi berdasarkan user login
        $transactions = Transaction::where('buyer_id', auth()->id())
            ->with(['store', 'transactionDetails.product'])
            ->latest()
            ->get();

        return view('history.index', compact('transactions'));
    }

    public function show($id)
    {
        $transaction = Transaction::where('id', $id)
            ->where('buyer_id', auth()->id()) // biar tidak bisa melihat punya orang
            ->with(['store', 'transactionDetails.product'])
            ->firstOrFail();

        return view('history.show', compact('transaction'));
    }
}
