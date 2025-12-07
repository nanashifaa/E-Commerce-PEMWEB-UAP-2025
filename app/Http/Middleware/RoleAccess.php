<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class RoleAccess
{
    public function handle(Request $request, Closure $next, $roles)
    {
        $user = auth()->user();

        // Jika belum login → login page
        if (!$user) {
            return redirect()->route('login');
        }

        // "buyer|seller|admin" → array
        $allowedRoles = explode('|', $roles);

        // Jika role user tidak diizinkan
        if (!in_array($user->role, $allowedRoles)) {
            abort(403, 'Unauthorized.');
        }

        return $next($request);
    }
}
