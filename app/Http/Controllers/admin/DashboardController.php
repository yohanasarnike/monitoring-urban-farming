<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\TanamanDitanam;
use App\Models\KriteriaTanaman;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Carbon;

class DashboardController extends Controller
{
    public function index()
    {
        $tanamanAktif = TanamanDitanam::all();

        return view('admin.dashboard');
    }
    public function kelolaData(Request $request)
    {
        $query = KriteriaTanaman::query();

        if ($request->filled('cari')) {
            $query->where('nama_tanaman', 'like', '%' . $request->cari . '%');
        }

        $dataTanaman = $query->orderBy('id_tanaman', 'asc')->get();

        return view('tanaman.kelolaDataTanaman', compact('dataTanaman'));
    }

    public function storeKriteria(Request $request)
    {
        $validated = $request->validate([
            'nama_tanaman' => 'required|string|max:150',
            'usia_panen'   => 'nullable|numeric',
            'pH_min'       => 'nullable|numeric',
            'pH_max'       => 'nullable|numeric',
            'suhu_min'     => 'nullable|numeric',
            'suhu_max'     => 'nullable|numeric',
        ]);

        KriteriaTanaman::create($validated);

        return redirect()->route('admin.kelola-data')
            ->with('success', 'Data tanaman berhasil ditambahkan ke database.');
    }

    public function updateKriteria(Request $request, $id)
    {
        $validated = $request->validate([
            'nama_tanaman' => 'required|string|max:150',
            'usia_panen'   => 'nullable|numeric',
            'pH_min'       => 'nullable|numeric',
            'pH_max'       => 'nullable|numeric',
            'suhu_min'     => 'nullable|numeric',
            'suhu_max'     => 'nullable|numeric',
        ]);

        $tanaman = KriteriaTanaman::findOrFail($id);
        $tanaman->update($validated);

        return redirect()->route('admin.kelola-data')
            ->with('success', 'Data tanaman berhasil diperbarui di database.');
    }

    public function destroyKriteria($id)
    {
        $tanaman = KriteriaTanaman::findOrFail($id);
        $tanaman->delete();

        return redirect()->route('admin.kelola-data')
            ->with('success', 'Data tanaman berhasil dihapus dari database.');
    }


    // ==========================================
    // DAFTAR PENGGUNA, PENCARIAN, DAN FILTER
    // ==========================================

    public function monitoring(Request $request)
    {
        // Mengambil nilai pencarian dan filter
        $search = trim($request->query('search', ''));
        $kondisi = $request->query('kondisi', '');
        $tanggal = $request->query('tanggal', '');

        // Validasi input filter
        $request->validate([
            'search' => 'nullable|string|max:255',
            'kondisi' => 'nullable|in:Sehat,Perhatian,Terkena Hama',
            'tanggal' => 'nullable|date',
        ]);

        // Query utama daftar pengguna
        $query = DB::table('pemilik_tanaman as p')
            ->where('p.ROLE', 'pengguna')
            ->select('p.*');

        // Mengambil daftar jenis tanaman milik pengguna
        $query->selectSub(function ($subquery) {

            $subquery->from('tanaman_ditanam as td')
                ->selectRaw(
                    'GROUP_CONCAT(DISTINCT td.jenis_bibit SEPARATOR ", ")'
                )
                ->whereColumn(
                    'td.id_pemilik_tanaman',
                    'p.id_pemilik_tanaman'
                );
        }, 'daftar_tanaman');

        // ==========================================
        // PENCARIAN NAMA, EMAIL, DAN JENIS TANAMAN
        // ==========================================

        if ($search !== '') {

            $query->where(function ($q) use ($search) {

                $q->where('p.username', 'LIKE', "%{$search}%")
                    ->orWhere('p.email', 'LIKE', "%{$search}%")

                    // Pencarian berdasarkan jenis tanaman
                    ->orWhereExists(function ($subquery) use ($search) {

                        $subquery->select(DB::raw(1))
                            ->from('tanaman_ditanam as td')
                            ->whereColumn(
                                'td.id_pemilik_tanaman',
                                'p.id_pemilik_tanaman'
                            )
                            ->where(
                                'td.jenis_bibit',
                                'LIKE',
                                "%{$search}%"
                            );
                    });
            });
        }

        // ==========================================
        // FILTER BERDASARKAN KONDISI DAN TANGGAL
        // ==========================================

        if ($kondisi !== '' || $tanggal !== '') {

            $query->whereExists(function ($subquery) use ($kondisi, $tanggal) {

                $subquery->select(DB::raw(1))
                    ->from('perawatan as pr')
                    ->join(
                        'tanaman_ditanam as td',
                        'td.id_tanaman_ditanam',
                        '=',
                        'pr.id_tanaman_ditanam'
                    )
                    ->whereColumn(
                        'td.id_pemilik_tanaman',
                        'p.id_pemilik_tanaman'
                    );

                // Filter kondisi tanaman
                if ($kondisi !== '') {
                    $subquery->where('pr.kondisi', $kondisi);
                }

                // Filter tanggal perawatan
                if ($tanggal !== '') {
                    $subquery->whereDate(
                        'pr.tanggal_perawatan',
                        $tanggal
                    );
                }
            });
        }

        // Mengambil pengguna sesuai pencarian dan filter
        $pengguna = $query
            ->orderBy('p.username')
            ->get();

        // ==========================================
        // MENGHITUNG STATISTIK MONITORING
        // ==========================================

        // Total tanaman yang dimiliki seluruh pengguna
        $totalDipantau = DB::table('tanaman_ditanam as td')
            ->join(
                'pemilik_tanaman as p',
                'p.id_pemilik_tanaman',
                '=',
                'td.id_pemilik_tanaman'
            )
            ->where('p.ROLE', 'pengguna')
            ->count('td.id_tanaman_ditanam');

        // Query dasar untuk menghitung kondisi perawatan
        $rekapPerawatan = DB::table('perawatan as pr')
            ->join(
                'tanaman_ditanam as td',
                'td.id_tanaman_ditanam',
                '=',
                'pr.id_tanaman_ditanam'
            )
            ->join(
                'pemilik_tanaman as p',
                'p.id_pemilik_tanaman',
                '=',
                'td.id_pemilik_tanaman'
            )
            ->where('p.ROLE', 'pengguna')
            ->whereNotNull('pr.tanggal_perawatan');

        // Jumlah data perawatan dengan kondisi sehat
        $kondisiSehat = (clone $rekapPerawatan)
            ->where('pr.kondisi', 'Sehat')
            ->count();

        // Jumlah data perawatan dengan kondisi perhatian
        // atau terkena hama
        $terkenaHama = (clone $rekapPerawatan)
            ->whereIn('pr.kondisi', [
                'Perhatian',
                'Terkena Hama',
            ])
            ->count();

        /*
         * Sementara masih 0 karena nama kolom status
         * Selesai Dikerjakan pada tabel perawatan belum diketahui.
         */
        $perawatanSelesai = 0;

        return view(
            'admin.monitoring',
            compact(
                'pengguna',
                'totalDipantau',
                'kondisiSehat',
                'terkenaHama',
                'perawatanSelesai'
            )
        );
    }

    // ==========================================
    // MENAMPILKAN TANAMAN MILIK PENGGUNA
    // ==========================================

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
                ->where(
                    'id_tanaman_ditanam',
                    $item->id_tanaman_ditanam
                )
                ->where('id_pemilik_tanaman', $id)
                ->whereNotNull('tanggal_perawatan')
                ->whereNotNull('tinggi_tanaman')
                ->orderBy('tanggal_perawatan')
                ->orderBy('waktu_perawatan')
                ->orderBy('id_jadwal')
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
                        'id_jadwal' => $terakhir->id_jadwal,
                        'minggu' => $minggu,
                        'tanggal' => $terakhir->tanggal_perawatan,
                        'waktu' => $terakhir->waktu_perawatan ?? '-',
                        'tinggi_tanaman' => $terakhir->tinggi_tanaman ?? '-',
                        'suhu' => $terakhir->suhu ?? '-',
                        'ph' => $terakhir->pH_tanaman ?? '-',
                        'kondisi' => $terakhir->kondisi ?? '',
                        'keterangan' => $terakhir->keterangan ?? '',
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

    // ==========================================
    // DETAIL MONITORING TANAMAN
    // ==========================================

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
            ->where('pemilik_tanaman.ROLE', 'pengguna')
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
            ->orderBy('id_jadwal')
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

        // Menghitung umur tanaman
        $umurTanaman = max(
            0,
            $tanggalTanam->diffInDays(
                Carbon::today()->startOfDay()
            )
        );

        return view(
            'admin.detail-monitoring',
            compact('data', 'perkembangan', 'umurTanaman')
        );
    }

    // ==========================================
    // UPDATE KONDISI DAN CATATAN
    // ==========================================

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
        $perawatan = DB::table('perawatan as pr')
            ->join(
                'pemilik_tanaman as p',
                'p.id_pemilik_tanaman',
                '=',
                'pr.id_pemilik_tanaman'
            )
            ->where('pr.id_jadwal', $id)
            ->where('p.ROLE', 'pengguna')
            ->select('pr.id_jadwal')
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