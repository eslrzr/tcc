<?php

namespace App\Http\Controllers\Auth;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Lang;
use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class AuthController extends Controller {

    /**
     * Build the login view
     * @return \Illuminate\Contracts\View\View
     */
    public function loginView() {
        return view('auth.login');
    }

    /**
     * Authenticate the user
     * @return \Illuminate\Http\RedirectResponse
     */
    public function authenticate() {
        $credentials = request()->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        $user = User::where('email', $credentials['email'])->first();
        if (!$user) {
            return back()->withErrors([
                'email' => Lang::get('auth.failed'),
            ]);
        }

        if (!$user->status) {
            return back()->withErrors([
                'email' => Lang::get('auth.inactive'),
            ]);
        }

        if (Auth::attempt($credentials)) {
            request()->session()->regenerate();
            return redirect()->intended('/admin/');
        }

        return back()->withErrors([
            'password' => Lang::get('auth.password'),
        ]);
    }

    /**
     * Logout the user
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function logout(Request $request) {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
     
        return redirect('/');
    }
}