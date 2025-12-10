<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class BalanceController extends Controller
{
    public function index()
    {
        return view('seller.balance', ['message' => 'Balance Page - Under Construction']);
    }
}
