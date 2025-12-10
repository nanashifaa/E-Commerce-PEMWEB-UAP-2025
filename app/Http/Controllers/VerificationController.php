<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Store;


class VerificationController extends Controller
{
    public function index()
    {
        // Ambil semua store dengan status pending
        $pendingStores = Store::where('is_verified', false)->get();

        // Ambil store yang sudah verified
        $approvedStores = Store::where('is_verified', true)->get();

        return view('admin.verification.index', compact('pendingStores', 'approvedStores'));
    }

    public function approve(Store $store)
    {
        $store->update(['is_verified' => true]);
        $store->user->update(['role' => 'seller']);
        return back()->with('success', 'Store approved successfully!');
    }

    public function reject(Store $store)
    {
        $store->delete();
        return back()->with('success', 'Store rejected and removed!');
    }
}
