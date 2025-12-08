<?php

namespace App\Http\Controllers;

use App\Models\Store;

class SellerDashboardController extends Controller
{
    public function index()
    {
        $store = Store::where('user_id', auth()->id())->first();

        return view('seller.dashboard', compact('store'));
    }
}
