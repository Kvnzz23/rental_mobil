<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function showLogin()
    {
        return view('pages.auth.login');
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email'    => 'required|email',
            'password' => 'required'
        ]);

        // 1. Cari user berdasarkan email terlebih dahulu
        $user = User::where('email', $credentials['email'])->first();

        // 2. Jika email tidak ditemukan di database
        if (!$user) {
            return back()->withErrors([
                'email' => 'Email tersebut tidak terdaftar di sistem.'
            ])->onlyInput('email');
        }

        // 3. Jika email ada, cek kecocokan password-nya
        if (!Hash::check($credentials['password'], $user->password)) {
            return back()->withErrors([
                'password' => 'Password yang Anda masukkan salah.'
            ])->onlyInput('email');
        }

        // 4. Jika keduanya benar, loginkan user & regenerasi session
        Auth::login($user);
        $request->session()->regenerate();

        return redirect()->intended('/');
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/login');
    }
}
