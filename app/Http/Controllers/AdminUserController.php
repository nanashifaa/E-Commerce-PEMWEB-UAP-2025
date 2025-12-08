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

    // === Tambahan Baru ===
    
    public function edit(User $user)
    {
        return view('admin.users.edit', compact('user'));
    }

    public function update(Request $request, User $user)
    {
        $request->validate([
            'role' => 'required|in:admin,seller,member',
        ]);

        $user->update([
            'role' => $request->role
        ]);

        return redirect()->route('admin.users')->with('success', 'Role updated successfully!');
    }

    public function delete(User $user)
    {
        $user->delete();
        return back()->with('success', 'User deleted successfully');
    }

}
