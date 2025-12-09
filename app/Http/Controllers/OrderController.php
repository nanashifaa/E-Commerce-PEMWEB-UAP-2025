<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order;

class OrderController extends Controller
{
    public function index()
{
    // ambil store milik seller yang login
    $storeId = auth()->user()->store->id;

    // ambil transaksi berdasarkan store_id
    $orders = Order::where('store_id', $storeId)
        ->latest()
        ->get();

    return view('seller.orders.index', compact('orders'));
}

}
