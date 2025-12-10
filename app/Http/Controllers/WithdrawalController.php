<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class WithdrawalController extends Controller
{
    public function index()
    {
        return view('seller.withdrawals', ['message' => 'Withdrawals Page - Under Construction']);
    }
}
