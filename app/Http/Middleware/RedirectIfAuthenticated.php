<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class RedirectIfAuthenticated
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @param  string|null  $guard
     * @return mixed
     */
    public function handle($request, Closure $next, $guard = null)
    {
        if (Auth::guard($guard)->check()) {
            $user = Auth::user();

            if ($user->role === 'admin') {
                // Redirect logged-in admin to admin dashboard
                return redirect('/admin');
            } else {
                // Redirect non-admin users to frontend home/dashboard
                return redirect('/');
            }
        }

        return $next($request);
    }
}
