<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class VerificationController extends Controller
{
    public function index()
    {
        $stores = Store::with('user')
                        ->where('is_verified', false)
                        ->orderBy('created_at', 'desc')
                        ->get();

        return view('admin.verification.index', compact('stores'));
    }

    // Approve store
    public function approve(Store $store)
    {
        $store->update([
            'is_verified' => true
        ]);

        return back()->with('success', 'Store approved successfully.');
    }

    // Reject store (hapus)
    public function reject(Store $store)
    {
        $store->delete();

        return back()->with('success', 'Store rejected and removed.');
    }}
