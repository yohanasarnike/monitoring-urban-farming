<?php

namespace App\Http\Controllers;

use App\Models\Konsultasi;
use Illuminate\Http\Request;

class ConsultationController extends Controller
{
    public function index()
    {
        $messages = Konsultasi::all();
        return view('konsultasi.chat', compact('messages'));
    }

    public function store(Request $request)
    {
        try {
            $request->validate([
                'message' => 'required|string',
            ]);

            // Ambil ID pertama dari tabel pemilik_tanaman agar tidak melanggar Foreign Key Constraint
            $idPemilik = \DB::table('pemilik_tanaman')->value('id_pemilik_tanaman') ?? 1;

            $msg = Konsultasi::create([
                'id_pemilik_tanaman'   => $idPemilik,
                'pertanyaan_konsultasi' => $request->message,
                'jawaban_konsultasi'   => null,
                'waktu_konsultasi'     => date('Y-m-d'), // Format DATE sesuai kolom di database
                'status'               => 'Pending',
            ]);

            return response()->json([
                'status' => 'success',
                'data' => [
                    'id' => $msg->id_konsultasi,
                    'message' => $msg->pertanyaan_konsultasi,
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