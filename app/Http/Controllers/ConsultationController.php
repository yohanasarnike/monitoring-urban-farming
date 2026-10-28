<?php

namespace App\Http\Controllers;

use App\Models\Konsultasi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;

class ConsultationController extends Controller
{
    public function index()
    {
        // Ambil pesan konsultasi milik pengguna yang sedang login
        $userId = Session::get('user_id');
        
        if ($userId) {
            $messages = Konsultasi::where('id_pemilik_tanaman', $userId)->get();
        } else {
            $messages = Konsultasi::all();
        }

        return view('konsultasi.chat', compact('messages'));
    }

    public function store(Request $request)
    {
        try {
            $request->validate([
                'message' => 'required|string',
            ]);

            // Ambil ID pemilik tanaman yang sedang login, fallback ke ID pertama jika tidak ada session
            $idPemilik = Session::get('user_id') ?? DB::table('pemilik_tanaman')->value('id_pemilik_tanaman') ?? 1;

            $msg = Konsultasi::create([
                'id_pemilik_tanaman'    => $idPemilik,
                'pertanyaan_konsultasi' => $request->message,
                'jawaban_konsultasi'    => null,
                'waktu_konsultasi'     => now(), // Menggunakan DATETIME saat ini (YYYY-MM-DD HH:MM:SS)
                'status'                => 'Menunggu',
            ]);

            return response()->json([
                'status' => 'success',
                'data' => [
                    'id' => $msg->id_konsultasi,
                    'message' => $msg->pertanyaan_konsultasi,
                    'waktu' => $msg->waktu_konsultasi,
                    'status' => $msg->status,
                ]
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => $e->getMessage()
            ], 500);
        }
    }
}