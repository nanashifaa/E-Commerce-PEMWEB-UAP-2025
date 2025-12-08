<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User; 

class AdminUserController extends Controller
{
public function index()
    {
        // Ambil semua user + store yang dimiliki user
        $users = User::with('store')->get();

        return view('admin.users.index', compact('users'));
    }
}
