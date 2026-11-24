<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class NotifikasiController extends Controller
{
    public function index()
    {
        $userId = Auth::id();

        if (!$userId) {
            return redirect()->route('login');
        }

        Carbon::setLocale('id');
        $today = Carbon::today();
        $startOfWeek = Carbon::now()->startOfWeek();
        $endOfWeek = Carbon::now()->endOfWeek();

        // Ambil data jadwal perawatan khusus milik user yang sedang login
        $jadwalPerawatan = DB::table('perawatan')
            ->join('tanaman_ditanam', 'perawatan.id_tanaman_ditanam', '=', 'tanaman_ditanam.id_tanaman_ditanam')
            ->where('perawatan.id_pemilik_tanaman', $userId)
            ->select(
                'perawatan.id_jadwal',
                'perawatan.tanggal_perawatan',
                'perawatan.waktu_perawatan',
                'perawatan.jenis_pupuk',
                'perawatan.keterangan',
                'tanaman_ditanam.jenis_bibit',
                'tanaman_ditanam.lokasi_tanam'
            )
            ->orderBy('perawatan.tanggal_perawatan', 'desc')
            ->orderBy('perawatan.waktu_perawatan', 'desc')
            ->get();

        $hariIni = [];
        $mingguIni = [];

        foreach ($jadwalPerawatan as $item) {
            $tgl = Carbon::parse($item->tanggal_perawatan);
            $waktuFull = $item->waktu_perawatan
                ? Carbon::parse($item->tanggal_perawatan . ' ' . $item->waktu_perawatan)
                : $tgl;

            // Tentukan jenis aksi berdasarkan keterangan atau jenis_pupuk
            $aksi = 'perawatan';
            $ketLower = strtolower($item->keterangan ?? '');
            if (str_contains($ketLower, 'siram')) {
                $aksi = 'penyiraman';
            } elseif (!empty($item->jenis_pupuk) || str_contains($ketLower, 'pupuk')) {
                $aksi = 'pemupukan' . (!empty($item->jenis_pupuk) ? ' (' . $item->jenis_pupuk . ')' : '');
            } elseif (!empty($item->keterangan)) {
                $aksi = $item->keterangan;
            }

            $notifData = [
                'id'      => 'perawatan_' . $item->id_jadwal,
                'tanaman' => $item->jenis_bibit,
                'lokasi'  => $item->lokasi_tanam,
                'pesan'   => "saatnya melakukan {$aksi} untuk {$item->jenis_bibit}" . ($item->lokasi_tanam ? " ({$item->lokasi_tanam})" : ""),
                'waktu'   => $tgl->isToday()
                                ? $waktuFull->diffForHumans()
                                : strtolower($tgl->translatedFormat('d F')),
            ];

            if ($tgl->isToday()) {
                $hariIni[] = $notifData;
            } elseif ($tgl->between($startOfWeek, $endOfWeek)) {
                $mingguIni[] = $notifData;
            }
        }

        // Cek estimasi panen tanaman milik user yang sedang login (H-3 sampai hari H)
        $tanamanUser = DB::table('tanaman_ditanam')
            ->leftJoin('kriteria_tanaman', 'tanaman_ditanam.jenis_bibit', '=', 'kriteria_tanaman.nama_tanaman')
            ->where('tanaman_ditanam.id_pemilik_tanaman', $userId)
            ->select(
                'tanaman_ditanam.id_tanaman_ditanam',
                'tanaman_ditanam.jenis_bibit',
                'tanaman_ditanam.tanggal_tanam',
                'kriteria_tanaman.usia_panen'
            )
            ->get();

        foreach ($tanamanUser as $tanaman) {
            if (!empty($tanaman->tanggal_tanam) && !empty($tanaman->usia_panen)) {
                $estimasiPanen = Carbon::parse($tanaman->tanggal_tanam)->addDays((int) $tanaman->usia_panen);
                $sisaHari = $today->diffInDays($estimasiPanen, false);

                if ($sisaHari >= 0 && $sisaHari <= 3) {
                    $teksPanen = $sisaHari === 0
                        ? "hari ini memasuki estimasi panen {$tanaman->jenis_bibit}!"
                        : "estimasi panen {$tanaman->jenis_bibit} dalam {$sisaHari} hari lagi";

                    array_unshift($hariIni, [
                        'id'      => 'panen_' . $tanaman->id_tanaman_ditanam,
                        'tanaman' => $tanaman->jenis_bibit,
                        'pesan'   => $teksPanen,
                        'waktu'   => 'Hari ini',
                    ]);
                }
            }
        }

        return view('notifications', compact('hariIni', 'mingguIni'));
    }
}