<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class Admin
{
    /**
     * Handle an incoming request.
     */
    public function handle($request, Closure $next)
    {
        if (Auth::check() && in_array($request->user()->role, ['admin', 'superadmin'])) {
            return $next($request);
        }

        // If not admin/superadmin
        Auth::logout();
        return redirect()->route('login.form')->with('error', 'You do not have permission to access this page.');
    }
}
