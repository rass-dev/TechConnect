<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class User
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if (!Auth::check()) {
            return redirect()->route('login.form')->with('error', 'Please log in to continue.');
        }

        if (Auth::user()->status !== 'active') {
            Auth::logout();
            $request->session()->forget('user');

            return redirect()->route('login.form')->with('error', 'Your account is inactive.');
        }

        return $next($request);
    }
}
