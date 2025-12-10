<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class RoleAccess
{
    public function handle(Request $request, Closure $next, ...$roles)
    {
        $user = auth()->user();

        // Not logged in
        if (!$user) {
            return redirect()->route('login');
        }

        // Check user role
        if (!in_array($user->role, $roles)) {
            abort(403, 'Unauthorized');
        }

        return $next($request);
    }
}
