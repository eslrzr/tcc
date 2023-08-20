<?php

namespace App\Http\Controllers\Auth;

use App\Models\SystemLog;
use App\Models\User;
// use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Lang;
use App\Http\Controllers\Controller;

class AuthController extends Controller {

    public function loginView() {
        if (Auth::check()) {
            return redirect()->route('home');
        }
        return view('auth.login');
    }

    public function authenticate() {
        $credentials = request()->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        if (Auth::attempt($credentials)) {
            request()->session()->regenerate();
            return redirect()->route('home');
        }

        return back()->withErrors([
            'email' => Lang::get('auth.failed'),
        ]);
    }

    public function logout() {
        Auth::logout();
        request()->session()->invalidate();
        request()->session()->regenerateToken();
        return redirect('/');
    }

    /**
     * Returns if the user is logged in
     * @return bool
     */
    public function isLoggedIn(): bool {
        return auth()->check();
    }
}