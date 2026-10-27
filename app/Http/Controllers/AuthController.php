<?php

namespace App\Http\Controllers;

<<<<<<< HEAD
use App\Models\User;
=======
use App\Models\Pemilik;
>>>>>>> 0e4d64dca97610822af8f317a9434d7c7f84cfcf
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
<<<<<<< HEAD
    // Menampilkan halaman login
=======
>>>>>>> 0e4d64dca97610822af8f317a9434d7c7f84cfcf
    public function showLogin()
    {
        return view('auth.login');
    }

<<<<<<< HEAD
    // Proses login
=======
>>>>>>> 0e4d64dca97610822af8f317a9434d7c7f84cfcf
    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => ['required', 'email'],
<<<<<<< HEAD
            'password' => ['required'],
        ]);

        if (Auth::attempt($credentials)) {
=======
            'password' => ['required', 'string'],
        ]);

        if (Auth::guard('web')->attempt($credentials)) {
>>>>>>> 0e4d64dca97610822af8f317a9434d7c7f84cfcf
            $request->session()->regenerate();

            return redirect()->intended(route('dashboard'));
        }

        return back()
            ->withErrors([
                'email' => 'Email atau password salah.',
            ])
            ->onlyInput('email');
    }

<<<<<<< HEAD
    // Menampilkan halaman daftar akun
=======
>>>>>>> 0e4d64dca97610822af8f317a9434d7c7f84cfcf
    public function showRegister()
    {
        return view('auth.register');
    }

<<<<<<< HEAD
    // Proses pendaftaran akun
    public function register(Request $request)
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'max:255', 'unique:users,email'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ]);

        $user = User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'password' => Hash::make($validated['password']),
        ]);

        Auth::login($user);
        $request->session()->regenerate();

        return redirect()->route('dashboard');
    }

    // Proses logout
    public function logout(Request $request)
    {
        Auth::logout();
=======
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
>>>>>>> 0e4d64dca97610822af8f317a9434d7c7f84cfcf

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('login');
    }
<<<<<<< HEAD
}
=======
}
>>>>>>> 0e4d64dca97610822af8f317a9434d7c7f84cfcf
