<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Konsultasi;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Contracts\Encryption\DecryptException;

class ConsultationController extends Controller
{
    public function index()
    {
        if (!Auth::check()) {
            return redirect()->route('login');
        }

        // Ambil ID pemilik tanaman yang sedang login (isolasi per akun)
        $userId = Auth::user()->id_pemilik_tanaman ?? Auth::user()->id_pemilik ?? Auth::id();

        $messages = Konsultasi::where('id_pemilik_tanaman', $userId)
            ->orderBy('id_konsultasi', 'asc')
            ->get();

        // Dekripsi pesan sebelum ditampilkan ke halaman chat user
        foreach ($messages as $msg) {
            if (!empty($msg->pertanyaan_konsultasi)) {
                try {
                    $msg->pertanyaan_konsultasi = Crypt::decryptString($msg->pertanyaan_konsultasi);
                } catch (DecryptException $e) {
                    // Tetap tampilkan apa adanya jika data lama belum terenkripsi
                }
            }

            if (!empty($msg->jawaban_konsultasi)) {
                try {
                    $msg->jawaban_konsultasi = Crypt::decryptString($msg->jawaban_konsultasi);
                } catch (DecryptException $e) {
                    // Tetap tampilkan apa adanya jika data lama belum terenkripsi
                }
            }
        }

        return view('konsultasi.chat', compact('messages'));
    }

    public function store(Request $request)
    {
        if (!Auth::check()) {
            return response()->json([
                'status'  => 'error',
                'message' => 'Sesi login berakhir, silakan login ulang.'
            ], 401);
        }

        $request->validate([
            'message' => 'required|string|max:2000',
        ]);

        // Ambil ID pemilik tanaman yang sedang login
        $userId = Auth::user()->id_pemilik_tanaman ?? Auth::user()->id_pemilik ?? Auth::id();
        $plainText = $request->message;

        // Simpan ke database dalam bentuk terenkripsi (AES-256-CBC Laravel)
        $konsultasi = Konsultasi::create([
            'id_pemilik_tanaman'    => $userId,
            'pertanyaan_konsultasi' => Crypt::encryptString($plainText),
        ]);

        return response()->json([
            'status'  => 'success',
            'message' => 'Pesan berhasil dikirim dan dienkripsi',
            'data'    => [
                'id'      => $konsultasi->id_konsultasi,
                'message' => $plainText, // Kembalikan plaintext ke layar pengirim
            ]
        ]);
    }
}