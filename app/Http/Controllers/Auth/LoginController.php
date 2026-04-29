<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Socialite;
use App\Models\User;
use Auth;

class LoginController extends Controller
{
    use AuthenticatesUsers;

    /**
     * Default redirect after login
     */
    protected $redirectTo = '/admin';

    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    /**
     * Allow only active users to log in
     */
    protected function credentials(Request $request)
    {
        return [
            'email'    => $request->email,
            'password' => $request->password,
            'status'   => 'active',
        ];
    }

    /**
     * Redirect after login based on role
     */
    protected function authenticated(Request $request, $user)
    {
        // Both admin & superadmin papasok sa /admin
        if (in_array($user->role, ['admin', 'superadmin'])) {
            return redirect()->intended('/admin');
        }

        Auth::logout();
        return redirect()->route('login.form')->with('error', 'Unauthorized access.');
    }

    /**
     * Socialite redirect to provider
     */
    public function redirect($provider)
    {
        return Socialite::driver($provider)->redirect();
    }

    /**
     * Socialite callback
     */
    public function callback($provider)
    {
        $userSocial = Socialite::driver($provider)->stateless()->user();
        $users = User::where(['email' => $userSocial->getEmail()])->first();

        if ($users) {
            // Allow only admin/superadmin roles
            if (!in_array($users->role, ['admin', 'superadmin'])) {
                return redirect()->route('login.form')->with('error', 'Unauthorized access.');
            }

            Auth::login($users);
            return redirect('/admin')->with('success', 'You are logged in from ' . $provider);
        }

        return redirect()->route('login.form')->with('error', 'Unauthorized access.');
    }
}
