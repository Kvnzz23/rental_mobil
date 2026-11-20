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

        // Otomatis mencari user berdasarkan email, mengecek Hash::check password, dan menjalankan Auth::login()
        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();

            return redirect()->intended('/');
        }

        // Jika email tidak ada ATAU password salah
        return back()->withErrors([
            'email' => 'Email atau password yang Anda masukkan salah.',
        ])->onlyInput('email');
    }

    // public function login(Request $request)
    // {
    //     $credentials = $request->validate([
    //         'email'    => 'required|email',
    //         'password' => 'required'
    //     ]);

    //     $user = User::where('email', $credentials['email'])->first();

    //     if (!$user) {
    //         return back()->withErrors([
    //             'email' => 'Email tersebut tidak terdaftar di sistem.'
    //         ])->onlyInput('email');
    //     }

    //     if (!Hash::check($credentials['password'], $user->password)) {
    //         return back()->withErrors([
    //             'password' => 'Password yang Anda masukkan salah.'
    //         ])->onlyInput('email');
    //     }

    //     Auth::login($user);
    //     $request->session()->regenerate();

    //     return redirect()->intended('/');
    // }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/login');
    }
}
