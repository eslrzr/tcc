<?php

namespace App\Http\Controllers\Auth;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Lang;
use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

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
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function authenticate(Request $request) {
        $validator = Validator::make($request->all(), [
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator);
        }

        $credentials = $request->only('email', 'password');

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

    /**
     * Change the user password
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function changePassword(Request $request) {
        $validator = Validator::make($request->all(), [
            'old_password' => ['required', 'confirmed'],
            'password' => ['required', 'min:8'],
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator);
        }

        $credentials = $request->only('old_password', 'password');

        $user = User::find(Auth::id());
        if (!Hash::check($credentials['old_password'], $user->password)) {
            return back()->withErrors([
                'old_password' => Lang::get('auth.password'),
            ]);
        }

        $user->password = Hash::make($credentials['password']);
        $user->save();

        return back()->with('success', Lang::get('auth.password_changed'));
    }
}