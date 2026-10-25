<?php

namespace App\Http\Controllers;

use App\Models\TanamanDitanam;
use App\Models\Perawatan;
use App\Models\KriteriaTanaman;
use Illuminate\Http\Request;
use Carbon\Carbon;

class TanamanController extends Controller
{
    public function create()
    {
        return view('tanaman.create');
    }

    // Menampilkan halaman dashboard
    public function index()
    {
        $idPemilik = 2; // Mocked user ID

        $tanamanAktif = TanamanDitanam::where('id_pemilik_tanaman', $idPemilik)->get();

        $jadwalPerawatan = Perawatan::with('tanaman')
            ->where('id_pemilik_tanaman', $idPemilik)
            ->orderBy('tanggal_perawatan', 'asc')
            ->get();

        return view('dashboard', compact('tanamanAktif', 'jadwalPerawatan'));
    }

    // Proses menyimpan tanaman baru dan generate jadwal otomatis berbasis kriteria sampai panen
    public function store(Request $request)
    {
        // 1. Validasi Input Form dari User (Diubah ke 'lokasi_tanam')
        $request->validate([
            'jenis_bibit'     => 'required|string|max:255',
            'tanggal_tanam'   => 'required|date',
            'suhu'            => 'required|numeric',
            'ph_tanah'        => 'required|numeric',
            'kelembapan'      => 'required|numeric',
            'jenis_lahan'     => 'required|string',
            'lokasi_tanam'    => 'required|string',
            'tinggi_tanaman'  => 'required|numeric',
            'jenis_pupuk'     => 'required|string',
            'kondisi_tanaman' => 'required|string',
        ]);

        $idPemilik = 2; // Mocked user ID

        // 2. Cek dan Ambil Data dari Tabel 'kriteria_tanaman' Berdasarkan Jenis Bibit
        $kriteria = KriteriaTanaman::where('nama_tanaman', 'LIKE', '%' . $request->jenis_bibit . '%')->first();

        $usiaPanen = $kriteria ? $kriteria->usia_panen : 90; // Default 90 hari jika tidak ditemukan
        $suhuMin   = $kriteria ? $kriteria->suhu_min : 18.00;
        $suhuMax   = $kriteria ? $kriteria->suhu_max : 30.00;
        $pHMin     = $kriteria ? $kriteria->pH_min : 5.50;
        $pHMax     = $kriteria ? $kriteria->pH_max : 6.50;

        // 3. Simpan Data Utama ke Tabel 'tanaman_ditanam'
        $tanaman = TanamanDitanam::create([
            'id_pemilik_tanaman' => $idPemilik,
            'jenis_bibit'        => $request->jenis_bibit,
            'tinggi_awal'        => $request->tinggi_tanaman,
            'jenis_lahan'        => $request->jenis_lahan,
            'tanggal_tanam'      => $request->tanggal_tanam,
            'lokasi_tanam'       => $request->lokasi_tanam,
        ]);

        $tglTanam = Carbon::parse($request->tanggal_tanam);

        // 4. GENERATE JADWAL OTOMATIS BERKELANJUTAN SAMPAI MASA PANEN

        // A. Jadwal Hari Pertama (Penanaman Awal)
        Perawatan::create([
            'id_pemilik_tanaman' => $idPemilik,
            'id_tanaman_ditanam' => $tanaman->id_tanaman_ditanam,
            'tanggal_perawatan'  => $tglTanam->format('Y-m-d'),
            'waktu_perawatan'    => '07:30:00',
            'suhu'               => $request->suhu,
            'pH_tanaman'         => $request->ph_tanah,
            'jenis_pupuk'        => $request->jenis_pupuk,
            'kondisi'            => $request->kondisi_tanaman,
            'tinggi_tanaman'     => $request->tinggi_tanaman,
            'kelembapan'         => $request->kelembapan,
            'keterangan'         => "Penanaman awal. Standar ideal: Suhu ({$suhuMin}-{$suhuMax}°C), pH ({$pHMin}-{$pHMax}).",
        ]);

        // B. Looping Jadwal Berkala dari Hari ke-2 hingga Hari Panen
        for ($hari = 2; $hari <= $usiaPanen; $hari++) {
            $currentDate = $tglTanam->copy()->addDays($hari - 1);

            // Penyiraman rutin setiap 2 hari sekali
            if ($hari % 2 == 0) {
                Perawatan::create([
                    'id_pemilik_tanaman' => $idPemilik,
                    'id_tanaman_ditanam' => $tanaman->id_tanaman_ditanam,
                    'tanggal_perawatan'  => $currentDate->format('Y-m-d'),
                    'waktu_perawatan'    => '08:00:00',
                    'suhu'               => $request->suhu,
                    'pH_tanaman'         => $request->ph_tanah,
                    'jenis_pupuk'        => '-',
                    'kondisi'            => 'Belum Dicek (Terjadwal)',
                    'tinggi_tanaman'     => $request->tinggi_tanaman + ($hari * 0.2),
                    'kelembapan'         => $request->kelembapan,
                    'keterangan'         => "Jadwal otomatis: Penyiraman rutin hari ke-{$hari}.",
                ]);
            }

            // Pemupukan rutin setiap 7 hari sekali (Mingguan)
            if ($hari % 7 == 0) {
                Perawatan::create([
                    'id_pemilik_tanaman' => $idPemilik,
                    'id_tanaman_ditanam' => $tanaman->id_tanaman_ditanam,
                    'tanggal_perawatan'  => $currentDate->format('Y-m-d'),
                    'waktu_perawatan'    => '09:00:00',
                    'suhu'               => $request->suhu,
                    'pH_tanaman'         => $request->ph_tanah,
                    'jenis_pupuk'        => $request->jenis_pupuk,
                    'kondisi'            => 'Belum Dicek (Terjadwal)',
                    'tinggi_tanaman'     => $request->tinggi_tanaman + ($hari * 0.2),
                    'kelembapan'         => $request->kelembapan,
                    'keterangan'         => "Jadwal otomatis: Pemupukan rutin mingguan (Hari ke-{$hari}) menggunakan {$request->jenis_pupuk}.",
                ]);
            }
        }

        // C. Jadwal Puncak: Hari Panen Tiba (Berdasarkan kriteria_tanaman -> usia_panen)
        $tglPanen = $tglTanam->copy()->addDays($usiaPanen);
        Perawatan::create([
            'id_pemilik_tanaman' => $idPemilik,
            'id_tanaman_ditanam' => $tanaman->id_tanaman_ditanam,
            'tanggal_perawatan'  => $tglPanen->format('Y-m-d'),
            'waktu_perawatan'    => '08:00:00',
            'suhu'               => $request->suhu,
            'pH_tanaman'         => $request->ph_tanah,
            'jenis_pupuk'        => '-',
            'kondisi'            => 'Siap Panen',
            'tinggi_tanaman'     => $request->tinggi_tanaman + 30,
            'kelembapan'         => $request->kelembapan,
            'keterangan'         => "Puncak Panen! Tanaman siap dipanen sesuai siklus kriteria ({$usiaPanen} hari).",
        ]);

        // 5. Redirect ke Halaman Jadwal Perawatan
        return redirect('/jadwal-perawatan')->with('success', 'Jadwal lengkap berhasil di-generate hingga masa panen!');
    }

    // Menampilkan jadwal perawatan spesifik berdasarkan tanaman yang dipilih
    public function jadwalIndex($id = null)
    {
        $idPemilik = 2; // Mocked user ID

        // Ambil daftar semua tanaman aktif milik user untuk tombol pilihan filter
        $daftarTanaman = TanamanDitanam::where('id_pemilik_tanaman', $idPemilik)->get();
        $query = Perawatan::with('tanaman')->where('id_pemilik_tanaman', $idPemilik);

        // Jika user memilih tanaman tertentu, filter jadwalnya
        if ($id) {
            $query->where('id_tanaman_ditanam', $id);
        }

        $tanamanAktif = TanamanDitanam::with('perawatan')
            ->where('id_pemilik_tanaman', $idPemilik)
            ->get();

        $jadwalPerawatan = collect();
        $tanamanPilih = null;
        if ($id) {
            $tanamanPilih = TanamanDitanam::where('id_pemilik_tanaman', $idPemilik)
                ->where('id_tanaman_ditanam', $id)
                ->first();

            $jadwalPerawatan = Perawatan::where('id_tanaman_ditanam', $id)
                ->orderBy('tanggal_perawatan', 'asc')
                ->get();
        }

        $jadwalPerawatan = $query->orderBy('tanggal_perawatan', 'asc')->get();
        return view('jadwal.index', compact('jadwalPerawatan', 'daftarTanaman', 'tanamanAktif', 'id'));
    }
}
