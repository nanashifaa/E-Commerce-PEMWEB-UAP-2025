<?php

namespace App\Http\Controllers;

use App\Models\Store;
use App\Models\Order;
use App\Models\Product;

class SellerDashboardController extends Controller
{
    public function index()
    {
        $store = Store::where('user_id', auth()->id())->first();

        $totalRevenue = 0;
        $activeProducts = 0;
        $pendingOrders = 0;
        $latestOrders = collect();

        if ($store && $store->is_verified) {
            $totalRevenue = Order::where('store_id', $store->id)
                ->where('payment_status', 'paid')
                ->sum('grand_total');

            $activeProducts = Product::where('store_id', $store->id)
                ->where('stock', '>', 0)
                ->count();

            $pendingOrders = Order::where('store_id', $store->id)
                ->where('payment_status', 'unpaid')
                ->count();

            $latestOrders = Order::with('buyer')
                ->where('store_id', $store->id)
                ->latest()
                ->take(5)
                ->get();
        }

        return view('seller.dashboard', compact(
            'store',
            'totalRevenue',
            'activeProducts',
            'pendingOrders',
            'latestOrders'
        ));
    }
}
