<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Store;

class AdminDashboardController extends Controller
{
public function index()
    {
        return view('admin.dashboard', [
            'totalUsers' => User::count(),
            'totalSellers' => User::where('role', 'seller')->count(),
            'pendingStores' => Store::where('is_verified', false)->count(),
        ]);
    }
}
