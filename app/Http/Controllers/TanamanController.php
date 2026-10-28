<?php

namespace App\Http\Controllers;

use App\Models\TanamanDitanam;
use App\Models\Perawatan;
use App\Models\KriteriaTanaman;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class TanamanController extends Controller
{
    public function create()
    {
        $daftarKriteria = KriteriaTanaman::all();

        $previousUrl = url()->previous();
        $fromDashboard = str_contains($previousUrl, '/dashboard');

        return view('tanaman.create', compact(
            'daftarKriteria',
            'fromDashboard'
        ));
    }

    /**
     * Mengambil kriteria berdasarkan nama tanaman.
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
     * Menghasilkan jadwal sementara.
     * Fungsi ini TIDAK menyimpan jadwal ke database.
     */
    private function generateJadwalTanaman($tanaman)
    {
        $kriteria = $this->ambilKriteria($tanaman->jenis_bibit);

        if (!$kriteria || (int) $kriteria->usia_panen <= 0) {
            return collect();
        }

        $usiaPanen = (int) $kriteria->usia_panen;

        $tanggalTanam = Carbon::parse(
            $tanaman->tanggal_tanam
        )->startOfDay();

        // Ambil catatan yang benar-benar sudah disimpan.
        $catatanTersimpan = Perawatan::where(
            'id_pemilik_tanaman',
            $tanaman->id_pemilik_tanaman
        )->where(
            'id_tanaman_ditanam',
            $tanaman->id_tanaman_ditanam
        )->get();

        // Catatan aktual diprioritaskan daripada jadwal sementara.
        $tanggalSudahDicatat = $catatanTersimpan
            ->pluck('tanggal_perawatan')
            ->filter()
            ->map(function ($tanggal) {
                return Carbon::parse($tanggal)->format('Y-m-d');
            })
            ->unique()
            ->values()
            ->all();

        $jadwal = collect();

        for ($hari = 0; $hari <= $usiaPanen; $hari++) {
            $tanggal = $tanggalTanam->copy()->addDays($hari);
            $tanggalFormat = $tanggal->format('Y-m-d');

            $penyiraman = $hari > 0 && $hari % 2 === 0;
            $pemupukan = $hari > 0 && $hari % 7 === 0;
            $panen = $hari === $usiaPanen;

            // Hari pertama sudah dicatat ketika tanaman ditambahkan.
            // Jika sudah ada catatan pada tanggal ini, jangan membuat
            // jadwal sementara duplikat untuk tanggal yang sama.
            if (in_array($tanggalFormat, $tanggalSudahDicatat)) {
                continue;
            }

            if ($hari === 0) {
                $waktu = '07:30:00';
                $jenisPupuk = null;
                $kondisi = 'Belum Dicek';
                $keterangan = 'Pemantauan awal tanaman '
                    . $tanaman->jenis_bibit . '.';
            } elseif ($panen) {
                $waktu = '08:00:00';
                $jenisPupuk = '-';
                $kondisi = 'Siap Panen';
                $keterangan = 'Tanaman ' . $tanaman->jenis_bibit
                    . ' diperkirakan siap dipanen pada hari ke-'
                    . $usiaPanen . '.';
            } elseif ($pemupukan) {
                $waktu = '09:00:00';
                $jenisPupuk = 'Pupuk Organik Cair';
                $kondisi = 'Belum Dicek (Terjadwal)';

                $keterangan = $penyiraman
                    ? 'Penyiraman dan pemupukan tanaman '
                        . $tanaman->jenis_bibit
                        . ' hari ke-' . $hari . '.'
                    : 'Pemupukan tanaman '
                        . $tanaman->jenis_bibit
                        . ' hari ke-' . $hari . '.';
            } elseif ($penyiraman) {
                $waktu = '08:00:00';
                $jenisPupuk = '-';
                $kondisi = 'Belum Dicek (Terjadwal)';
                $keterangan = 'Penyiraman tanaman '
                    . $tanaman->jenis_bibit
                    . ' hari ke-' . $hari . '.';
            } else {
                continue;
            }

            // Objek ini hanya digunakan untuk tampilan.
            // Tidak ada Perawatan::create() di bagian ini.
            $jadwal->push((object) [
                'id_jadwal' => null,
                'id_pemilik_tanaman' => $tanaman->id_pemilik_tanaman,
                'id_tanaman_ditanam' => $tanaman->id_tanaman_ditanam,
                'tanggal_perawatan' => $tanggalFormat,
                'waktu_perawatan' => $waktu,
                'suhu' => null,
                'pH_tanaman' => null,
                'jenis_pupuk' => $jenisPupuk,
                'kondisi' => $kondisi,
                'tinggi_tanaman' => null,
                'kelembapan' => null,
                'keterangan' => $keterangan,
                'catatan_harian' => null,
                'status' => 'Pending',
                'tanaman' => $tanaman,
            ]);
        }

        return $jadwal;
    }

    /**
     * Menggabungkan jadwal sementara dan catatan aktual.
     */
    private function ambilSemuaJadwal($tanamanAktif, $idPemilik)
    {
        $hasil = collect();

        foreach ($tanamanAktif as $tanaman) {
            // Jadwal sementara yang belum memiliki catatan.
            $hasil = $hasil->merge(
                $this->generateJadwalTanaman($tanaman)
            );

            // Catatan aktual yang benar-benar tersimpan.
            $catatan = Perawatan::with('tanaman')
                ->where('id_pemilik_tanaman', $idPemilik)
                ->where(
                    'id_tanaman_ditanam',
                    $tanaman->id_tanaman_ditanam
                )
                ->get();

            $hasil = $hasil->merge($catatan);
        }

        return $hasil
            ->sortBy(function ($item) {
                return ($item->tanggal_perawatan ?? '9999-12-31')
                    . ' '
                    . ($item->waktu_perawatan ?? '00:00:00');
            })
            ->values();
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

        if ($tanamanAktif->isEmpty()) {
            return redirect('/tanaman/tambah')
                ->with(
                    'info',
                    'Silakan tambahkan tanaman pertama kamu terlebih dahulu.'
                );
        }

        $jadwalPerawatan = $this->ambilSemuaJadwal(
            $tanamanAktif,
            $idPemilik
        );

        return view('dashboard', compact(
            'tanamanAktif',
            'jadwalPerawatan'
        ));
    }

    /**
     * Menyimpan tanaman baru.
     * Hanya catatan awal yang disimpan.
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

        $kriteria = $this->ambilKriteria($request->jenis_bibit);

        if (!$kriteria) {
            return back()
                ->withInput()
                ->withErrors([
                    'jenis_bibit' =>
                        'Kriteria tanaman tidak ditemukan. Periksa nama tanaman pada tabel kriteria tanaman.',
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

            // Simpan hanya catatan penanaman awal.
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
                'keterangan' => 'Penanaman awal '
                    . $request->jenis_bibit . '.',
                'status' => 'Selesai',
            ]);
        });

        return redirect('/dashboard')
            ->with('success', 'Tanaman berhasil ditambahkan.');
    }

    /**
     * Halaman kalender jadwal perawatan.
     */
    public function jadwalIndex(Request $request, $id = null)
    {
        $idPemilik = Auth::id();

        $id = $request->query('id', $id);

        $tanamanAktif = TanamanDitanam::where(
            'id_pemilik_tanaman',
            $idPemilik
        )->get();

        $daftarTanaman = $tanamanAktif;
        $tanamanPilih = null;

        if ($id) {
            $tanamanPilih = $tanamanAktif->firstWhere(
                'id_tanaman_ditanam',
                (int) $id
            );

            // Jangan mengizinkan filter tanaman milik pengguna lain.
            if (!$tanamanPilih) {
                abort(404);
            }
        }

        $tanamanUntukJadwal = $id
            ? $tanamanAktif->where(
                'id_tanaman_ditanam',
                (int) $id
            )
            : $tanamanAktif;

        $semuaJadwal = $this->ambilSemuaJadwal(
            $tanamanUntukJadwal,
            $idPemilik
        );

        $tanggalAdaJadwal = $semuaJadwal
            ->pluck('tanggal_perawatan')
            ->filter()
            ->map(function ($tanggal) {
                return Carbon::parse($tanggal)->format('Y-m-d');
            })
            ->unique()
            ->values()
            ->toArray();

        if ($request->filled('tanggal')) {
            $semuaJadwal = $semuaJadwal
                ->filter(function ($jadwal) use ($request) {
                    return Carbon::parse(
                        $jadwal->tanggal_perawatan
                    )->format('Y-m-d') === $request->tanggal;
                })
                ->values();
        }

        $jadwalPerawatan = $semuaJadwal;

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
     * Menyimpan atau memperbarui catatan perawatan.
     *
     * ID 0 berarti jadwal sementara yang belum tersimpan.
     */
    public function updatePerawatan(Request $request, $id)
    {
        $request->validate([
            'id_tanaman_ditanam' => 'required|integer',
            'tanggal_perawatan' => 'required|date',
            'suhu' => 'nullable|numeric',
            'pH_tanaman' => 'nullable|numeric',
            'tinggi_tanaman' => 'nullable|numeric',
            'kelembapan' => 'nullable|numeric',
            'kondisi' => 'nullable|string|max:100',
            'catatan_harian' => 'nullable|string',
            'status' => 'nullable|in:Selesai',
        ]);

        $idPemilik = Auth::id();

        // Pastikan tanaman memang milik pengguna yang sedang login.
        $tanaman = TanamanDitanam::where(
            'id_tanaman_ditanam',
            $request->id_tanaman_ditanam
        )->where(
            'id_pemilik_tanaman',
            $idPemilik
        )->firstOrFail();

        if ((int) $id > 0) {
            // Perbarui catatan yang sudah tersimpan.
            $perawatan = Perawatan::where(
                'id_jadwal',
                $id
            )->where(
                'id_pemilik_tanaman',
                $idPemilik
            )->where(
                'id_tanaman_ditanam',
                $tanaman->id_tanaman_ditanam
            )->firstOrFail();
        } else {
            // Jadwal sementara baru dibuat menjadi catatan saat disimpan.
            $perawatan = Perawatan::firstOrNew([
                'id_pemilik_tanaman' => $idPemilik,
                'id_tanaman_ditanam' => $tanaman->id_tanaman_ditanam,
                'tanggal_perawatan' => Carbon::parse(
                    $request->tanggal_perawatan
                )->format('Y-m-d'),
            ]);

            if (!$perawatan->exists) {
                $perawatan->waktu_perawatan = '08:00:00';
            }
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

        if ($request->has('status')) {
            $perawatan->status = 'Selesai';
        } else {
            $perawatan->status = 'Pending';
        }

        if ($request->filled('catatan_harian')) {
            // Catatan disimpan di kolom keterangan karena struktur
            // tabel yang diberikan tidak memiliki kolom catatan_harian.
            $perawatan->keterangan = $request->catatan_harian;
        }

        $perawatan->save();

        return redirect()->back()->with(
            'success',
            'Data perawatan berhasil diperbarui!'
        );
    }
}