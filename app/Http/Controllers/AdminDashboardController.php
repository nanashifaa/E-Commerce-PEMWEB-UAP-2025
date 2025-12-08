<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Store;
use App\Models\Product;

class AdminDashboardController extends Controller
{
    public function index()
    {
        // contoh data untuk dashboard admin
        $totalUsers = User::count();
        $totalStores = Store::count();
        $pendingStores = Store::where('is_verified', false)->count();
        $totalProducts = Product::count();

        return view('admin.dashboard', compact(
            'totalUsers',
            'totalStores',
            'pendingStores',
            'totalProducts'
        ));
    }
}
