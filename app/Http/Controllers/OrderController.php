<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order;

class OrderController extends Controller
{
    public function index()
    {
        $user = auth()->user();

        if (!$user->store) {
            return redirect()
                ->route('store.register')
                ->with('error', 'Silakan buat toko terlebih dahulu.');
        }

        $storeId = $user->store->id;

        $orders = Order::with('buyer')
            ->where('store_id', $storeId)
            ->latest()
            ->get(); 

        return view('seller.orders.index', compact('orders'));
    }

    public function show($id)
    {
        $user = auth()->user();

        if (!$user->store) {
            abort(403, 'You do not have a store.');
        }

        $order = Order::with(['details.product', 'buyer'])
            ->where('store_id', $user->store->id)
            ->findOrFail($id);

        return view('seller.orders.show', compact('order'));
    }
}
