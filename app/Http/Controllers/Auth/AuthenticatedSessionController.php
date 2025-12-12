<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class AuthenticatedSessionController extends Controller
{
    /**
     * Tampilkan form login.
     */
    public function create(): View
    {
        return view('auth.login');
    }

    /**
     * Proses login.
     */
    public function store(LoginRequest $request): RedirectResponse
    {
        // Validasi + cek kredensial (pakai LoginRequest)
        $request->authenticate();

        // Regenerate session biar aman
        $request->session()->regenerate();

        $user = $request->user();

        $redirectRoute = match ($user->role) {
            'admin'  => 'admin.dashboard',   
            'seller' => 'seller.dashboard',
            default  => 'home',              
        };

        return redirect()->intended(route($redirectRoute));
    }

    public function destroy(Request $request): RedirectResponse
    {
        Auth::guard('web')->logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/');
    }
}
