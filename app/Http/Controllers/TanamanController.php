<?php

namespace App\Http\Controllers;

use App\Models\TanamanDitanam;
use App\Models\Perawatan;
use App\Models\KriteriaTanaman;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class TanamanController extends Controller
{
    public function create()
    {
        return view('tanaman.create');
    }

    /**
     * Mengambil kriteria tanaman berdasarkan nama bibit.
     */
    private function ambilKriteria($namaBibit)
    {
        $namaBibit = trim($namaBibit);

        $kriteria = KriteriaTanaman::whereRaw(
            'LOWER(TRIM(nama_tanaman)) = ?',
            [strtolower($namaBibit)]
        )->first();

        if (!$kriteria) {
            $kriteria = KriteriaTanaman::where(
                'nama_tanaman',
                'LIKE',
                '%' . $namaBibit . '%'
            )->first();
        }

        return $kriteria;
    }

    /**
     * Membuat jadwal yang belum tersedia sampai masa panen.
     * Jadwal lama tidak dihapus.
     */
    private function generateJadwalTanaman($tanaman, $idPemilik)
    {
        $kriteria = $this->ambilKriteria($tanaman->jenis_bibit);

        // Jangan membuat jadwal dengan usia panen yang salah.
        if (!$kriteria) {
            return;
        }

        $usiaPanen = (int) $kriteria->usia_panen;

        if ($usiaPanen <= 0) {
            return;
        }

        $suhuMin = (float) $kriteria->suhu_min;
        $suhuMax = (float) $kriteria->suhu_max;
        $pHMin = (float) $kriteria->pH_min;
        $pHMax = (float) $kriteria->pH_max;

        $suhuIdeal = ($suhuMin + $suhuMax) / 2;
        $pHIdeal = ($pHMin + $pHMax) / 2;

        $tinggiAwal = $tanaman->tinggi_awal ?? 5;

        $tglTanam = Carbon::parse(
            $tanaman->tanggal_tanam
        )->startOfDay();

        $idTanaman = $tanaman->id_tanaman_ditanam;

        // Pastikan jadwal yang diperiksa milik tanaman dan pemilik yang sama.
        $tanggalSudahAda = Perawatan::where(
            'id_pemilik_tanaman',
            $idPemilik
        )->where(
            'id_tanaman_ditanam',
            $idTanaman
        )->pluck('tanggal_perawatan')
            ->map(function ($tanggal) {
                return Carbon::parse($tanggal)->format('Y-m-d');
            })
            ->unique()
            ->values()
            ->all();

        // Jadwal hari pertama.
        $tanggalAwal = $tglTanam->format('Y-m-d');

        if (!in_array($tanggalAwal, $tanggalSudahAda)) {
            Perawatan::create([
                'id_pemilik_tanaman' => $idPemilik,
                'id_tanaman_ditanam' => $idTanaman,
                'tanggal_perawatan' => $tanggalAwal,
                'waktu_perawatan' => '07:30:00',
                'suhu' => null,           // Biarkan kosong sebelum diisi user
                'pH_tanaman' => null,     // Biarkan kosong sebelum diisi user
                'jenis_pupuk' => null,
                'kondisi' => 'Belum Dicek', // Ubah status awal jadi Belum Dicek
                'tinggi_tanaman' => null, // Biarkan kosong sebelum diisi user
                'kelembapan' => null,     // Biarkan kosong sebelum diisi user
                'keterangan' => null,
            ]);

            $tanggalSudahAda[] = $tanggalAwal;
        }

        // Jadwal perawatan berkala sampai usia panen.
        for ($hari = 2; $hari <= $usiaPanen; $hari++) {
            $tanggal = $tglTanam->copy()->addDays($hari);
            $tanggalFormat = $tanggal->format('Y-m-d');

            $penyiraman = ($hari % 2 === 0);
            $pemupukan = ($hari % 7 === 0);
            $panen = ($hari === $usiaPanen);

            if (!$penyiraman && !$pemupukan && !$panen) {
                continue;
            }

            // Jangan membuat jadwal baru jika tanggal tersebut
            // sudah memiliki jadwal perawatan.
            if (in_array($tanggalFormat, $tanggalSudahAda)) {
                continue;
            }

            if ($panen) {
                $jenisPupuk = '-';
                $kondisi = 'Siap Panen';
                $waktu = '08:00:00';

                $keterangan = "Puncak panen! {$tanaman->jenis_bibit} "
                    . "siap dipanen sesuai usia panen {$usiaPanen} hari.";
            } elseif ($pemupukan) {
                $jenisPupuk = 'Pupuk Organik Cair';
                $kondisi = 'Belum Dicek (Terjadwal)';
                $waktu = '09:00:00';

                $keterangan = $penyiraman
                    ? "Penyiraman dan pemupukan rutin {$tanaman->jenis_bibit} hari ke-{$hari}."
                    : "Pemupukan rutin {$tanaman->jenis_bibit} hari ke-{$hari}.";
            } else {
                $jenisPupuk = '-';
                $kondisi = 'Belum Dicek (Terjadwal)';
                $waktu = '08:00:00';

                $keterangan = "Penyiraman rutin {$tanaman->jenis_bibit} hari ke-{$hari}.";
            }

            Perawatan::create([
                'id_pemilik_tanaman' => $idPemilik,
                'id_tanaman_ditanam' => $idTanaman,
                'tanggal_perawatan' => $tanggalFormat,
                'waktu_perawatan' => $waktu,
                'suhu' => $suhuIdeal,
                'pH_tanaman' => $pHIdeal,
                'jenis_pupuk' => $jenisPupuk,
                'kondisi' => $kondisi,
                'tinggi_tanaman' => $panen
                    ? $tinggiAwal + 30
                    : $tinggiAwal + ($hari * 0.2),
                'kelembapan' => 80,
                'keterangan' => $keterangan,
            ]);

            $tanggalSudahAda[] = $tanggalFormat;
        }
    }

    /**
     * Dashboard.
     */
    public function index()
    {
        $idPemilik = Auth::id();

        $tanamanAktif = TanamanDitanam::where(
            'id_pemilik_tanaman',
            $idPemilik
        )->get();

        // 🟢 TAMBAHKAN INI: Jika user belum punya tanaman sama sekali, lempar ke halaman tambah tanaman!
        if ($tanamanAktif->isEmpty()) {
            return redirect('/tanaman/tambah')
                ->with('info', 'Silakan tambahkan tanaman pertama kamu terlebih dahulu.');
        }

        foreach ($tanamanAktif as $tanaman) {
            $this->generateJadwalTanaman(
                $tanaman,
                $idPemilik
            );
        }

        $jadwalPerawatan = Perawatan::with('tanaman')
            ->where('id_pemilik_tanaman', $idPemilik)
            ->orderBy('tanggal_perawatan', 'asc')
            ->orderBy('waktu_perawatan', 'asc')
            ->get();

        return view(
            'dashboard',
            compact('tanamanAktif', 'jadwalPerawatan')
        );
    }

    /**
     * Menyimpan tanaman baru dan membuat jadwalnya.
     */
    public function store(Request $request)
    {
        $request->validate([
            'jenis_bibit' => 'required|string|max:255',
            'tanggal_tanam' => 'required|date',
            'suhu' => 'required|numeric',
            'ph_tanah' => 'required|numeric',
            'kelembapan' => 'required|numeric',
            'jenis_lahan' => 'required|string',
            'lokasi_tanam' => 'required|string',
            'tinggi_tanaman' => 'required|numeric',
            'jenis_pupuk' => 'required|string',
            'kondisi_tanaman' => 'required|string',
        ]);

        $idPemilik = Auth::id();

        $kriteria = $this->ambilKriteria(
            $request->jenis_bibit
        );

        if (!$kriteria) {
            return back()
                ->withInput()
                ->withErrors([
                    'jenis_bibit' => 'Kriteria tanaman tidak ditemukan. Periksa nama tanaman pada tabel kriteria tanaman.',
                ]);
        }

        DB::transaction(function () use ($request, $idPemilik) {
            $tanaman = TanamanDitanam::create([
                'id_pemilik_tanaman' => $idPemilik,
                'jenis_bibit' => $request->jenis_bibit,
                'tinggi_awal' => $request->tinggi_tanaman,
                'jenis_lahan' => $request->jenis_lahan,
                'tanggal_tanam' => $request->tanggal_tanam,
                'lokasi_tanam' => $request->lokasi_tanam,
            ]);

            // Simpan data perawatan hari pertama sesuai input pengguna.
            Perawatan::create([
                'id_pemilik_tanaman' => $idPemilik,
                'id_tanaman_ditanam' => $tanaman->id_tanaman_ditanam,
                'tanggal_perawatan' => Carbon::parse(
                    $request->tanggal_tanam
                )->format('Y-m-d'),
                'waktu_perawatan' => '07:30:00',
                'suhu' => $request->suhu,
                'pH_tanaman' => $request->ph_tanah,
                'jenis_pupuk' => $request->jenis_pupuk,
                'kondisi' => $request->kondisi_tanaman,
                'tinggi_tanaman' => $request->tinggi_tanaman,
                'kelembapan' => $request->kelembapan,
                'keterangan' => "Penanaman awal {$request->jenis_bibit}.",
            ]);

            // Lengkapi jadwal sampai masa panen.
            $this->generateJadwalTanaman(
                $tanaman,
                $idPemilik
            );
        });

        return redirect('/dahboard');
    }

    /**
     * Halaman jadwal perawatan.
     */
    public function jadwalIndex(Request $request, $id = null)
    {
        $idPemilik = Auth::id();

        $id = $request->query('id', $id);

        $tanamanAktif = TanamanDitanam::where(
            'id_pemilik_tanaman',
            $idPemilik
        )->get();

        // Lengkapi jadwal tanaman lama yang masih belum lengkap.
        foreach ($tanamanAktif as $tanaman) {
            $this->generateJadwalTanaman(
                $tanaman,
                $idPemilik
            );
        }

        $daftarTanaman = $tanamanAktif;

        $query = Perawatan::with('tanaman')
            ->where('id_pemilik_tanaman', $idPemilik);

        if ($id) {
            $query->where(
                'id_tanaman_ditanam',
                $id
            );
        }

        if ($request->filled('tanggal')) {
            $query->whereDate(
                'tanggal_perawatan',
                $request->tanggal
            );
        }

        $tanamanPilih = null;

        if ($id) {
            $tanamanPilih = TanamanDitanam::where(
                'id_pemilik_tanaman',
                $idPemilik
            )->where(
                'id_tanaman_ditanam',
                $id
            )->first();
        }

        $queryTanggal = Perawatan::where(
            'id_pemilik_tanaman',
            $idPemilik
        );

        if ($id) {
            $queryTanggal->where(
                'id_tanaman_ditanam',
                $id
            );
        }

        $tanggalAdaJadwal = $queryTanggal
            ->pluck('tanggal_perawatan')
            ->map(function ($tanggal) {
                return Carbon::parse($tanggal)->format('Y-m-d');
            })
            ->unique()
            ->values()
            ->toArray();

        $jadwalPerawatan = $query
            ->orderBy('tanggal_perawatan', 'asc')
            ->orderBy('waktu_perawatan', 'asc')
            ->get();

        return view('jadwal.index', compact(
            'jadwalPerawatan',
            'daftarTanaman',
            'tanamanAktif',
            'id',
            'tanamanPilih',
            'tanggalAdaJadwal'
        ));
    }

    /**
     * Memperbarui status, tinggi, dan catatan harian perawatan tanaman.
     */
    public function updatePerawatan(Request $request, $id)
    {
        // Langsung pakai findOrFail($id) agar Laravel menyesuaikan primary key tabel otomatis
        $perawatan = Perawatan::findOrFail($id);

        // Timpa dengan data aktual dari input user
        if ($request->has('status')) {
            $perawatan->status = 'Selesai';
        } else {
            $perawatan->status = 'Pending';
        }

        if ($request->filled('suhu')) {
            $perawatan->suhu = $request->suhu;
        }
        if ($request->filled('pH_tanaman')) {
            $perawatan->pH_tanaman = $request->pH_tanaman;
        }
        if ($request->filled('tinggi_tanaman')) {
            $perawatan->tinggi_tanaman = $request->tinggi_tanaman;
        }
        if ($request->filled('kondisi')) {
            $perawatan->kondisi = $request->kondisi;
        }
        if ($request->filled('catatan_harian')) {
            $perawatan->catatan_harian = $request->catatan_harian;
            $perawatan->keterangan = "Update Pengguna: " . $request->catatan_harian;
        }

        $perawatan->save();

        return redirect()->back()->with('success', 'Data perawatan berhasil diperbarui!');
    }
}
