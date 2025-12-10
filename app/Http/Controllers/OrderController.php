<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order;

class OrderController extends Controller
{
    public function index()
    {
        // ambil store milik seller yang login
        $user = auth()->user();

        if (!$user->store) {
            return redirect()->route('store.register')->with('error', 'Silakan buat toko terlebih dahulu.');
        }

        $storeId = $user->store->id;

        // ambil transaksi berdasarkan store_id
        $orders = Order::where('store_id', $storeId)
            ->latest()
            ->get();

        return view('seller.orders.index', compact('orders'));
    }

    public function show($id)
    {
        $order = Order::with(['items.product', 'buyer'])->findOrFail($id);

        // Ensure the order belongs to the seller's store
        if ($order->store_id !== auth()->user()->store->id) {
            abort(403, 'Unauthorized action.');
        }

        return view('seller.orders.show', compact('order'));
    }
}
