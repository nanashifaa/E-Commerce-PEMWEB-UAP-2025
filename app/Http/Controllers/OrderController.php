<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order;

class OrderController extends Controller
{
    public function index()
    {
        $sellerId = auth()->id();

        $orders = Order::where('seller_id', $sellerId)
                        ->latest()
                        ->get();

        return view('seller.orders.index', compact('orders'));
    }
}
