<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Konsultasi;
use Illuminate\Support\Facades\Auth;

class ConsultationController extends Controller
{
    public function index()
    {
        $userId = Auth::user()->id_pemilik ?? Auth::id();

        $messages = Konsultasi::where('id_pemilik_tanaman', $userId)
            ->orderBy('id_konsultasi', 'asc')
            ->get();

        return view('konsultasi.chat', compact('messages'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'message' => 'required|string',
        ]);

        $userId = Auth::user()->id_pemilik ?? Auth::id();

        $konsultasi = Konsultasi::create([
            'id_pemilik_tanaman'    => $userId,
            'pertanyaan_konsultasi' => $request->message,
        ]);

        return response()->json([
            'status'  => 'success',
            'message' => 'Pesan berhasil dikirim',
            'data'    => [
                'message' => $konsultasi->pertanyaan_konsultasi
            ]
        ]);
    }
}