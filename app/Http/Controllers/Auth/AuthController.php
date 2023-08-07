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

    public function register() {
        $fields = request()->validate([
            'email' => ['required', 'email', 'unique:users,email'],
            'password' => ['required', 'confirmed'],
        ]);

        $fields['password'] = Hash::make($fields['password']);

        try {
            $user = User::create($fields);
            if ($user) {
                redirect()->back()->with('success', Lang::get('general.create_user_success'));
            }
        } catch (\Throwable $th) {
            SystemLog::create([
                'type' => 'error',
                'action' => 'register',
                'message' => $th->getMessage(),
                'user_id' => Auth::id(),
                'ip_address' => request()->ip(),
            ]);
            return back()->withErrors([
                // 'email' => Lang::get('general.erro_acao', ['attribute' => 'email']),
            ]);
        }
    }

    /**
     * Returns if the user is logged in
     * @return bool
     */
    public function isLoggedIn(): bool {
        return auth()->check();
    }
}