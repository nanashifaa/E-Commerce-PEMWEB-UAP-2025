<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Store;

class StoreController extends Controller
{
    public function create()
    {
        return view('seller.store.register');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name'        => 'required|string|max:255',
            'about'       => 'required|string',
            'phone'       => 'required|string',
            'city'        => 'required|string',
            'address'     => 'required|string',
            'postal_code' => 'required|string',
            'logo'        => 'nullable|image|max:2048'
        ]);

        $logoPath = null;
        if ($request->hasFile('logo')) {
            $logoPath = $request->file('logo')->store('store-logos', 'public');
        }

        Store::create([
            'user_id'     => auth()->id(),
            'name'        => $request->name,
            'logo'        => $logoPath,
            'about'       => $request->about,
            'phone'       => $request->phone,
            'city'        => $request->city,
            'address'     => $request->address,
            'postal_code' => $request->postal_code,
            'is_verified' => false,
        ]);

       return redirect()->route('seller.dashboard')
            ->with('success', 'Store successfully submitted! Waiting for admin verification.');
    }
}
