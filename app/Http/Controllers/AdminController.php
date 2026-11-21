<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Carbon;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    // Menampilkan dashboard admin
    public function index()
    {
        return view('admin.dashboard');
    }

    // Menampilkan daftar pengguna untuk dimonitoring
    public function monitoring()
    {
        $pengguna = DB::table('pemilik_tanaman')
            ->where('ROLE', 'pengguna')
            ->orderBy('username')
            ->get();

        return view('admin.monitoring', compact('pengguna'));
    }

    // Menampilkan tanaman dan perkembangan milik pengguna
    public function tanaman($id)
    {
        $pengguna = DB::table('pemilik_tanaman')
            ->where('id_pemilik_tanaman', $id)
            ->where('ROLE', 'pengguna')
            ->first();

        if (!$pengguna) {
            abort(404, 'Pengguna tidak ditemukan.');
        }

        $tanaman = DB::table('tanaman_ditanam')
            ->where('id_pemilik_tanaman', $id)
            ->orderBy('tanggal_tanam', 'desc')
            ->get();

        foreach ($tanaman as $item) {

            $tanggalTanam = Carbon::parse($item->tanggal_tanam)
                ->startOfDay();

            // Mengambil data perawatan tanaman
            $perawatan = DB::table('perawatan')
                ->where('id_tanaman_ditanam', $item->id_tanaman_ditanam)
                ->where('id_pemilik_tanaman', $id)
                ->whereNotNull('tanggal_perawatan')
                ->whereNotNull('tinggi_tanaman')
                ->orderBy('tanggal_perawatan')
                ->orderBy('waktu_perawatan')
                ->get();

            // Mengelompokkan perkembangan berdasarkan minggu
            $item->perkembangan = $perawatan
                ->filter(function ($data) use ($tanggalTanam) {

                    return Carbon::parse($data->tanggal_perawatan)
                        ->startOfDay()
                        ->greaterThanOrEqualTo($tanggalTanam);
                })
                ->groupBy(function ($data) use ($tanggalTanam) {

                    $tanggal = Carbon::parse(
                        $data->tanggal_perawatan
                    )->startOfDay();

                    $hari = $tanggalTanam->diffInDays($tanggal);

                    return (int) floor($hari / 7) + 1;
                })
                ->map(function ($items, $minggu) {

                    // Mengambil data perawatan terakhir pada minggu tersebut
                    $terakhir = $items->last();

                    return (object) [
                        // ID untuk proses update kondisi dan catatan
                        'id_jadwal' => $terakhir->id_jadwal,

                        'minggu' => $minggu,
                        'tanggal' => $terakhir->tanggal_perawatan,
                        'waktu' => $terakhir->waktu_perawatan ?? '-',
                        'tinggi_tanaman' => $terakhir->tinggi_tanaman ?? '-',
                        'suhu' => $terakhir->suhu ?? '-',
                        'ph' => $terakhir->pH_tanaman ?? '-',
                        'kondisi' => $terakhir->kondisi ?? '',
                        'keterangan' => $terakhir->keterangan ?? '',

                        // Data tambahan jika diperlukan
                        'kelembapan' => $terakhir->kelembapan ?? '-',
                        'jenis_pupuk' => $terakhir->jenis_pupuk ?? '-',
                    ];
                })
                ->values();
        }

        return view(
            'admin.tanaman',
            compact('pengguna', 'tanaman')
        );
    }

    // Method detail monitoring lama
    public function detailMonitoring($id)
    {
        $data = DB::table('tanaman_ditanam')
            ->join(
                'pemilik_tanaman',
                'tanaman_ditanam.id_pemilik_tanaman',
                '=',
                'pemilik_tanaman.id_pemilik_tanaman'
            )
            ->where(
                'tanaman_ditanam.id_tanaman_ditanam',
                $id
            )
            ->select(
                'tanaman_ditanam.*',
                'pemilik_tanaman.username'
            )
            ->first();

        if (!$data) {
            abort(404, 'Tanaman tidak ditemukan.');
        }

        $perawatan = DB::table('perawatan')
            ->where('id_tanaman_ditanam', $id)
            ->where(
                'id_pemilik_tanaman',
                $data->id_pemilik_tanaman
            )
            ->whereNotNull('tinggi_tanaman')
            ->whereNotNull('tanggal_perawatan')
            ->orderBy('tanggal_perawatan')
            ->orderBy('waktu_perawatan')
            ->get();

        $tanggalTanam = Carbon::parse($data->tanggal_tanam)
            ->startOfDay();

        $perkembangan = $perawatan
            ->filter(function ($item) use ($tanggalTanam) {

                return Carbon::parse($item->tanggal_perawatan)
                    ->startOfDay()
                    ->greaterThanOrEqualTo($tanggalTanam);
            })
            ->groupBy(function ($item) use ($tanggalTanam) {

                $tanggalPerawatan = Carbon::parse(
                    $item->tanggal_perawatan
                )->startOfDay();

                $hari = $tanggalTanam->diffInDays(
                    $tanggalPerawatan
                );

                return (int) floor($hari / 7) + 1;
            })
            ->map(function ($items, $minggu) {

                $terakhir = $items->last();

                return (object) [
                    'minggu' => $minggu,
                    'tinggi' => $terakhir->tinggi_tanaman,
                    'tanggal' => $terakhir->tanggal_perawatan,
                ];
            })
            ->values();

        $umurTanaman = $tanggalTanam->diffInDays(
            Carbon::today()->startOfDay()
        );

        return view(
            'admin.detail-monitoring',
            compact('data', 'perkembangan', 'umurTanaman')
        );
    }

    // Menyimpan pembaruan kondisi dan catatan dari admin
    public function updateKondisiCatatan(Request $request, $id)
    {
        $request->validate([
            'kondisi' => 'required|string|max:1000',
            'keterangan' => 'nullable|string|max:5000',
        ], [
            'kondisi.required' => 'Kondisi tanaman wajib diisi.',
            'kondisi.max' => 'Kondisi tanaman maksimal 1000 karakter.',
            'keterangan.max' => 'Catatan maksimal 5000 karakter.',
        ]);

        // Memastikan data perawatan tersedia
        $perawatan = DB::table('perawatan')
            ->where('id_jadwal', $id)
            ->first();

        if (!$perawatan) {
            return back()->with(
                'error',
                'Data perawatan tidak ditemukan.'
            );
        }

        // Memperbarui kondisi dan catatan admin
        DB::table('perawatan')
            ->where('id_jadwal', $id)
            ->update([
                'kondisi' => $request->kondisi,
                'keterangan' => $request->keterangan,
            ]);

        return back()->with(
            'success',
            'Kondisi dan catatan berhasil disimpan.'
        );
    }
}
