<?php

namespace App\Http\Controllers;

use App\Models\Pemilik;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function showLogin()
    {
        return view('auth.login');
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required', 'string'],
        ]);

        if (Auth::guard('web')->attempt($credentials)) {
            $request->session()->regenerate();

            return redirect()->intended(route('dashboard'));
        }

        return back()
            ->withErrors([
                'email' => 'Email atau password salah.',
            ])
            ->onlyInput('email');
    }

    public function showRegister()
    {
        return view('auth.register');
    }

    public function register(Request $request)
    {
        $validated = $request->validate([
            'nama' => ['required', 'string', 'max:150'],
            'email' => [
                'required',
                'email',
                'max:255',
                'unique:pemilik_tanaman,email',
            ],
            'password' => ['required', 'string', 'min:8'],
        ]);

        $pemilik = Pemilik::create([
            'username' => $validated['nama'],
            'email' => $validated['email'],
            'PASSWORD' => Hash::make($validated['password']),
            'ROLE' => 'pengguna',
        ]);
        return redirect()->route('login')
            ->with('success', 'Registrasi berhasil. Silakan masuk menggunakan akun yang baru saja kamu daftarkan');
    }

    public function logout(Request $request)
    {
        Auth::guard('web')->logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('login');
    }
}
