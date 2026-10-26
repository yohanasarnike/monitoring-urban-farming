<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function showLogin() {
        return view('auth.login');
    }

    public function showRegister() {
        return view('auth.register');
    }

    // Proses Register / Daftar Akun
    public function register(Request $request) {
        $request->validate([
            'nama'     => 'required|string|max:255',
            'email'    => 'required|email|unique:pemilik_tanaman,email',
            'password' => 'required|string',
        ]);

        User::create([
            'username' => $request->nama, // Menyesuaikan input form ke kolom 'username'
            'email'    => $request->email,
            'PASSWORD' => $request->password, // Disimpan sesuai teks aslimu (atau Hash::make jika ingin dienkripsi)
            'ROLE'     => 'pengguna',         // Role default untuk user baru mendaftar
        ]);

        return redirect('/login')->with('success', 'Akun berhasil dibuat! Silakan login.');
    }

    // Proses Login
    public function login(Request $request) {
        $request->validate([
            'email'    => 'required|email',
            'password' => 'required',
        ]);

        // Cari user berdasarkan email
        $user = User::where('email', $request->email)->first();

        // Cek apakah user ada dan passwordnya cocok (karena password di DB teks biasa)
        if ($user && $request->password === $user->PASSWORD) {
            Auth::login($user); // Login manual session Laravel
            $request->session()->regenerate();
            
            // CEK APAKAH USER SUDAH PERNAH INPUT TANAMAN ATAU BELUM
            // Menghitung jumlah tanaman milik user yang sedang login
            $jumlahTanaman = \App\Models\TanamanDitanam::where('id_pemilik_tanaman', $user->id_pemilik_tanaman)->count();

            if ($jumlahTanaman == 0) {
                // Jika belum pernah input sama sekali, arahkan ke form tambah tanaman dulu
                return redirect('/tanaman/tambah')->with('info', 'Silakan daftarkan tanaman pertama Anda terlebih dahulu.');
            } else {
                // Jika sudah pernah input, langsung ke dashboard utama
                return redirect('/dashboard');
            }
        }

        return back()->withErrors([
            'email' => 'Email atau password salah.',
        ]);
    }
}