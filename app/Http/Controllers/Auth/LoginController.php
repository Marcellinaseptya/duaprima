<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User; // Pastikan ini di-import

class LoginController extends Controller
{
    public function showLoginForm()
    {
        return view('auth.login');
    }

    public function login(Request $request)
    {
        // 1. Validasi input
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        // 2. Cari user berdasarkan email
        $user = User::where('email', $request->email)->first();

        if ($user && \Illuminate\Support\Facades\Hash::check($request->password, $user->password)) {
            
            // 4. Login-kan user secara manual ke session
            Auth::login($user);

            // 5. Redirect berdasarkan role (Logika kamu sudah benar di sini)
            switch ($user->role) {
                case 'admin':
                    return redirect()->route('admin.dashboard');
                case 'manajer':
                    return redirect()->route('manajer.dashboard');
                case 'sopir':
                    return redirect()->route('sopir.dashboard');
                case 'owner':
                    return redirect()->route('owner.dashboard');
                default:
                    return redirect('/');
            }
        }

        // Jika gagal login
        return back()->withErrors([
            'email' => 'Email atau password salah.',
        ])->withInput($request->only('email'));
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect()->route('login');
    }
}