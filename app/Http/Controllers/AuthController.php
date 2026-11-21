<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Pemilik;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;
use Illuminate\Support\Carbon;

class AuthController extends Controller
{
    // Menampilkan halaman login
    public function showLogin()
    {
        return view('auth.login');
    }

    // Proses login

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required', 'string'],
        ]);

        if (Auth::guard('web')->attempt($credentials)) {

            $request->session()->regenerate();

            $user = Auth::guard('web')->user();

            $role = strtolower(trim($user->ROLE));

            if ($role === 'admin') {
                return redirect()->route('admin.dashboard');
            }

            if ($role === 'pengguna') {
                return redirect()->route('dashboard');
            }

            Auth::guard('web')->logout();

            return redirect()->route('login')
                ->withErrors([
                    'email' => 'Role akun tidak dikenali.',
                ]);
        }

        return back()
            ->withErrors([
                'email' => 'Email atau password salah.',
            ])
            ->onlyInput('email');
    }


    // Menampilkan halaman daftar akun
    public function showRegister()
    {
        return view('auth.register');
    }

    // Proses pendaftaran akun
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

        Pemilik::create([
            'username' => $validated['nama'],
            'email' => $validated['email'],
            'PASSWORD' => Hash::make($validated['password']),
            'ROLE' => 'pengguna',
        ]);

        return redirect()->route('login')
            ->with('success', 'Registrasi berhasil. Silakan masuk menggunakan akun yang baru saja kamu daftarkan');
    }

    // Proses logout
    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('login');
    }

    // Menampilkan halaman lupa password
    public function showForgotPassword()
    {
        return view('auth.forgot-password');
    }

    // Mengirim link reset password
    public function sendResetLink(Request $request)
    {
        $request->validate([
            'email' => ['required', 'email'],
        ]);

        $pemilik = Pemilik::where('email', $request->email)->first();

        if (!$pemilik) {
            return back()->withErrors([
                'email' => 'Email tidak ditemukan.'
            ]);
        }

        $token = Str::random(64);

        DB::table('password_reset_tokens')->updateOrInsert(
            ['email' => $request->email],
            [
                'email' => $request->email,
                'token' => Hash::make($token),
                'created_at' => Carbon::now(),
            ]
        );

        $url = url('/reset-password/' . $token . '?email=' . urlencode($request->email));

        Mail::raw(
            "Halo!\n\nKlik link berikut untuk mengatur ulang password:\n\n$url",
            function ($message) use ($request) {
                $message->to($request->email)
                    ->subject('Reset Password UrbanFarming');
            }
        );

        return back()->with(
            'status',
            'Link reset password berhasil dikirim ke email kamu.'
        );
    }

    // Menampilkan halaman buat password baru
    public function showResetPassword(Request $request, $token)
    {
        $email = $request->query('email');

        $reset = DB::table('password_reset_tokens')
            ->where('email', $email)
            ->first();

        if (
            !$reset ||
            !Hash::check($token, $reset->token) ||
            Carbon::parse($reset->created_at)->addMinutes(60)->isPast()
        ) {
            return redirect()->route('password.request')
                ->withErrors([
                    'email' => 'Link reset password tidak valid atau kedaluwarsa.'
                ]);
        }

        return view('auth.reset-password', compact('token', 'email'));
    }

    // Menyimpan password baru
    public function resetPassword(Request $request)
    {
        $request->validate([
            'email' => ['required', 'email'],
            'token' => ['required'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ]);

        $reset = DB::table('password_reset_tokens')
            ->where('email', $request->email)
            ->first();

        if (
            !$reset ||
            !Hash::check($request->token, $reset->token) ||
            Carbon::parse($reset->created_at)->addMinutes(60)->isPast()
        ) {
            return back()->withErrors([
                'email' => 'Link reset password tidak valid atau kedaluwarsa.'
            ]);
        }

        $pemilik = Pemilik::where('email', $request->email)->first();

        if (!$pemilik) {
            return back()->withErrors([
                'email' => 'Akun tidak ditemukan.'
            ]);
        }

        $pemilik->PASSWORD = Hash::make($request->password);
        $pemilik->save();

        DB::table('password_reset_tokens')
            ->where('email', $request->email)
            ->delete();

        return redirect()->route('login')
            ->with('success', 'Password berhasil diubah. Silakan login kembali.');
    }
}
