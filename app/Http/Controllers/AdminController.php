<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Contracts\Encryption\DecryptException;
use Illuminate\Support\Carbon;
use Illuminate\Http\Request;
use App\Models\Konsultasi;

class AdminController extends Controller
{
    // ==========================================
    // DASHBOARD ADMIN
    // ==========================================

    public function index()
    {
        $konsultasiBaru = DB::table('konsultasi')
            ->where(function ($q) {
                $q->whereNull('status')
                  ->orWhere('status', '')
                  ->orWhere('status', 'belum_ditangani');
            })
            ->distinct('id_pemilik_tanaman')
            ->count('id_pemilik_tanaman');

        return view('admin.dashboard', compact('konsultasiBaru'));
    }

    // ==========================================
    // DAFTAR PENGGUNA, PENCARIAN, DAN FILTER
    // ==========================================

    public function monitoring(Request $request)
    {
        $search = trim($request->query('search', ''));
        $kondisi = $request->query('kondisi', '');
        $tanggal = $request->query('tanggal', '');

        $request->validate([
            'search' => 'nullable|string|max:255',
            'kondisi' => 'nullable|in:Sehat,Perhatian,Terkena Hama',
            'tanggal' => 'nullable|date',
        ]);

        $query = DB::table('pemilik_tanaman as p')
            ->where('p.ROLE', 'pengguna')
            ->select('p.*');

        $query->selectSub(function ($subquery) {
            $subquery->from('tanaman_ditanam as td')
                ->selectRaw('GROUP_CONCAT(DISTINCT td.jenis_bibit SEPARATOR ", ")')
                ->whereColumn('td.id_pemilik_tanaman', 'p.id_pemilik_tanaman');
        }, 'daftar_tanaman');

        if ($search !== '') {
            $query->where(function ($q) use ($search) {
                $q->where('p.username', 'LIKE', "%{$search}%")
                    ->orWhere('p.email', 'LIKE', "%{$search}%")
                    ->orWhereExists(function ($subquery) use ($search) {
                        $subquery->select(DB::raw(1))
                            ->from('tanaman_ditanam as td')
                            ->whereColumn('td.id_pemilik_tanaman', 'p.id_pemilik_tanaman')
                            ->where('td.jenis_bibit', 'LIKE', "%{$search}%");
                    });
            });
        }

        if ($kondisi !== '' || $tanggal !== '') {
            $query->whereExists(function ($subquery) use ($kondisi, $tanggal) {
                $subquery->select(DB::raw(1))
                    ->from('perawatan as pr')
                    ->join('tanaman_ditanam as td', 'td.id_tanaman_ditanam', '=', 'pr.id_tanaman_ditanam')
                    ->whereColumn('td.id_pemilik_tanaman', 'p.id_pemilik_tanaman');

                if ($kondisi !== '') {
                    $subquery->where('pr.kondisi', $kondisi);
                }

                if ($tanggal !== '') {
                    $subquery->whereDate('pr.tanggal_perawatan', $tanggal);
                }
            });
        }

        $pengguna = $query->orderBy('p.username')->get();

        $totalDipantau = DB::table('tanaman_ditanam as td')
            ->join('pemilik_tanaman as p', 'p.id_pemilik_tanaman', '=', 'td.id_pemilik_tanaman')
            ->where('p.ROLE', 'pengguna')
            ->count('td.id_tanaman_ditanam');

        $rekapPerawatan = DB::table('perawatan as pr')
            ->join('tanaman_ditanam as td', 'td.id_tanaman_ditanam', '=', 'pr.id_tanaman_ditanam')
            ->join('pemilik_tanaman as p', 'p.id_pemilik_tanaman', '=', 'td.id_pemilik_tanaman')
            ->where('p.ROLE', 'pengguna')
            ->whereNotNull('pr.tanggal_perawatan');

        $kondisiSehat = (clone $rekapPerawatan)->where('pr.kondisi', 'Sehat')->count();
        $terkenaHama = (clone $rekapPerawatan)->whereIn('pr.kondisi', ['Perhatian', 'Terkena Hama'])->count();
        $perawatanSelesai = 0;

        return view(
            'admin.monitoring',
            compact('pengguna', 'totalDipantau', 'kondisiSehat', 'terkenaHama', 'perawatanSelesai')
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
            $tanggalTanam = Carbon::parse($item->tanggal_tanam)->startOfDay();

            $perawatan = DB::table('perawatan')
                ->where('id_tanaman_ditanam', $item->id_tanaman_ditanam)
                ->where('id_pemilik_tanaman', $id)
                ->whereNotNull('tanggal_perawatan')
                ->whereNotNull('tinggi_tanaman')
                ->orderBy('tanggal_perawatan')
                ->orderBy('waktu_perawatan')
                ->orderBy('id_jadwal')
                ->get();

            $item->perkembangan = $perawatan
                ->filter(function ($data) use ($tanggalTanam) {
                    return Carbon::parse($data->tanggal_perawatan)->startOfDay()->greaterThanOrEqualTo($tanggalTanam);
                })
                ->groupBy(function ($data) use ($tanggalTanam) {
                    $tanggal = Carbon::parse($data->tanggal_perawatan)->startOfDay();
                    $hari = $tanggalTanam->diffInDays($tanggal);
                    return (int) floor($hari / 7) + 1;
                })
                ->map(function ($items, $minggu) {
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

        return view('admin.tanaman', compact('pengguna', 'tanaman'));
    }

    // ==========================================
    // DETAIL MONITORING TANAMAN
    // ==========================================

    public function detailMonitoring($id)
    {
        $data = DB::table('tanaman_ditanam')
            ->join('pemilik_tanaman', 'tanaman_ditanam.id_pemilik_tanaman', '=', 'pemilik_tanaman.id_pemilik_tanaman')
            ->where('tanaman_ditanam.id_tanaman_ditanam', $id)
            ->where('pemilik_tanaman.ROLE', 'pengguna')
            ->select('tanaman_ditanam.*', 'pemilik_tanaman.username')
            ->first();

        if (!$data) {
            abort(404, 'Tanaman tidak ditemukan.');
        }

        $perawatan = DB::table('perawatan')
            ->where('id_tanaman_ditanam', $id)
            ->where('id_pemilik_tanaman', $data->id_pemilik_tanaman)
            ->whereNotNull('tinggi_tanaman')
            ->whereNotNull('tanggal_perawatan')
            ->orderBy('tanggal_perawatan')
            ->orderBy('waktu_perawatan')
            ->orderBy('id_jadwal')
            ->get();

        $tanggalTanam = Carbon::parse($data->tanggal_tanam)->startOfDay();

        $perkembangan = $perawatan
            ->filter(function ($item) use ($tanggalTanam) {
                return Carbon::parse($item->tanggal_perawatan)->startOfDay()->greaterThanOrEqualTo($tanggalTanam);
            })
            ->groupBy(function ($item) use ($tanggalTanam) {
                $tanggalPerawatan = Carbon::parse($item->tanggal_perawatan)->startOfDay();
                $hari = $tanggalTanam->diffInDays($tanggalPerawatan);
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

        $umurTanaman = max(0, $tanggalTanam->diffInDays(Carbon::today()->startOfDay()));

        return view('admin.detail-monitoring', compact('data', 'perkembangan', 'umurTanaman'));
    }

    // ==========================================
    // UPDATE KONDISI DAN CATATAN
    // ==========================================

    public function updateKondisiCatatan(Request $request, $id)
    {
        $request->validate([
            'kondisi' => 'required|string|max:1000',
            'keterangan' => 'nullable|string|max:5000',
        ]);

        $perawatan = DB::table('perawatan as pr')
            ->join('pemilik_tanaman as p', 'p.id_pemilik_tanaman', '=', 'pr.id_pemilik_tanaman')
            ->where('pr.id_jadwal', $id)
            ->where('p.ROLE', 'pengguna')
            ->select('pr.id_jadwal')
            ->first();

        if (!$perawatan) {
            return back()->with('error', 'Data perawatan tidak ditemukan.');
        }

        DB::table('perawatan')
            ->where('id_jadwal', $id)
            ->update([
                'kondisi' => $request->kondisi,
                'keterangan' => $request->keterangan,
            ]);

        return back()->with('success', 'Kondisi dan catatan berhasil disimpan.');
    }

    // ==========================================
    // KONSULTASI ADMIN (DAFTAR, STATUS & CHAT)
    // ==========================================

    public function konsultasi(Request $request)
    {
        $tab = $request->query('tab', 'belum_ditangani');
        $search = trim($request->query('search', ''));

        $allChats = DB::table('konsultasi as k')
            ->join('pemilik_tanaman as p', 'p.id_pemilik_tanaman', '=', 'k.id_pemilik_tanaman')
            ->select(
                'k.*',
                'p.username',
                'p.email'
            )
            ->orderBy('k.id_konsultasi', 'desc')
            ->get();

        $groupedByUser = $allChats->groupBy('id_pemilik_tanaman')->map(function ($items) {
            $latest = $items->first();
            $rawStatus = strtolower(trim($latest->status ?? ''));

            if ($rawStatus === 'berjalan') {
                $normalizedStatus = 'berjalan';
            } elseif (in_array($rawStatus, ['selesai', 'ditolak', 'ditutup'])) {
                $normalizedStatus = 'selesai';
            } else {
                $normalizedStatus = 'belum_ditangani';
            }

            $previewText = '';
            $targetText = !empty($latest->pertanyaan_konsultasi)
                ? $latest->pertanyaan_konsultasi
                : ($latest->jawaban_konsultasi ?? '');

            if (!empty($targetText)) {
                try {
                    $previewText = Crypt::decryptString($targetText);
                } catch (DecryptException $e) {
                    $previewText = $targetText;
                }
            }

            $unreadCount = $items->filter(function ($row) {
                return !empty($row->pertanyaan_konsultasi) && empty($row->jawaban_konsultasi);
            })->count();

            $tanamanUser = DB::table('tanaman_ditanam')
                ->where('id_pemilik_tanaman', $latest->id_pemilik_tanaman)
                ->value('jenis_bibit');

            return (object) [
                'id_pemilik_tanaman' => $latest->id_pemilik_tanaman,
                'username'           => $latest->username,
                'email'              => $latest->email,
                'preview'            => $previewText,
                'status'             => $normalizedStatus,
                'raw_status'         => $rawStatus,
                'unread_count'       => $unreadCount > 0 ? $unreadCount : 1,
                'waktu'              => $latest->waktu_konsultasi,
                'topik'              => $tanamanUser ? "Perawatan {$tanamanUser}" : 'Konsultasi Tanaman',
            ];
        })->values();

        if ($search !== '') {
            $groupedByUser = $groupedByUser->filter(function ($u) use ($search) {
                return str_contains(strtolower($u->username), strtolower($search))
                    || str_contains(strtolower($u->email ?? ''), strtolower($search));
            })->values();
        }

        $countBelum = $groupedByUser->where('status', 'belum_ditangani')->count();
        $countBerjalan = $groupedByUser->where('status', 'berjalan')->count();
        $countSelesai = $groupedByUser->where('status', 'selesai')->count();

        $totalHariIni = DB::table('konsultasi')
            ->whereDate('waktu_konsultasi', Carbon::today())
            ->distinct('id_pemilik_tanaman')
            ->count('id_pemilik_tanaman');

        if ($totalHariIni === 0) {
            $totalHariIni = $countBelum + $countBerjalan;
        }

        $listKonsultasi = $groupedByUser->where('status', $tab)->values();

        return view('admin.konsultasi', compact(
            'tab',
            'search',
            'listKonsultasi',
            'countBelum',
            'countBerjalan',
            'countSelesai',
            'totalHariIni'
        ));
    }

    public function konsultasiUpdateStatus(Request $request, $userId)
    {
        $request->validate([
            'status' => 'required|in:belum_ditangani,berjalan,selesai,ditolak',
        ]);

        DB::table('konsultasi')
            ->where('id_pemilik_tanaman', $userId)
            ->update([
                'status' => $request->status,
            ]);

        $redirectTab = in_array($request->status, ['selesai', 'ditolak']) ? 'selesai' : $request->status;

        return redirect()
            ->route('admin.konsultasi', ['tab' => $redirectTab])
            ->with('success', 'Status konsultasi berhasil diperbarui.');
    }

    public function konsultasiChat($userId)
    {
        $pengguna = DB::table('pemilik_tanaman')
            ->where('id_pemilik_tanaman', $userId)
            ->first();

        if (!$pengguna) {
            abort(404, 'Pengguna tidak ditemukan.');
        }

        $messages = $this->getDecryptedUserChat($userId);

        $latest = Konsultasi::where('id_pemilik_tanaman', $userId)
            ->orderBy('id_konsultasi', 'desc')
            ->first();

        $sessionStatus = strtolower(trim($latest->status ?? 'berjalan'));

        return view('admin.konsultasi-chat', compact('pengguna', 'messages', 'sessionStatus'));
    }

    public function konsultasiReply(Request $request, $userId)
    {
        $request->validate([
            'message' => 'required|string|max:2000',
        ]);

        $plainReply = $request->message;
        $encryptedReply = Crypt::encryptString($plainReply);

        $unanswered = Konsultasi::where('id_pemilik_tanaman', $userId)
            ->whereNotNull('pertanyaan_konsultasi')
            ->where(function ($q) {
                $q->whereNull('jawaban_konsultasi')
                  ->orWhere('jawaban_konsultasi', '');
            })
            ->orderBy('id_konsultasi', 'asc')
            ->first();

        if ($unanswered) {
            $unanswered->update([
                'jawaban_konsultasi' => $encryptedReply,
                'status'             => 'berjalan',
            ]);
            $recordId = $unanswered->id_konsultasi;
        } else {
            $baru = Konsultasi::create([
                'id_pemilik_tanaman' => $userId,
                'jawaban_konsultasi' => $encryptedReply,
                'waktu_konsultasi'   => Carbon::now(),
                'status'             => 'berjalan',
            ]);
            $recordId = $baru->id_konsultasi;
        }

        DB::table('konsultasi')
            ->where('id_pemilik_tanaman', $userId)
            ->update(['status' => 'berjalan']);

        return response()->json([
            'status' => 'success',
            'data'   => [
                'id'      => $recordId,
                'message' => $plainReply,
            ]
        ]);
    }

    public function konsultasiFetchMessages($userId)
    {
        $messages = $this->getDecryptedUserChat($userId);

        return response()->json([
            'status'   => 'success',
            'messages' => $messages,
        ]);
    }

    private function getDecryptedUserChat($userId)
    {
        $messages = Konsultasi::where('id_pemilik_tanaman', $userId)
            ->orderBy('id_konsultasi', 'asc')
            ->get();

        foreach ($messages as $msg) {
            if (!empty($msg->pertanyaan_konsultasi)) {
                try {
                    $msg->pertanyaan_konsultasi = Crypt::decryptString($msg->pertanyaan_konsultasi);
                } catch (DecryptException $e) {
                }
            }

            if (!empty($msg->jawaban_konsultasi)) {
                try {
                    $msg->jawaban_konsultasi = Crypt::decryptString($msg->jawaban_konsultasi);
                } catch (DecryptException $e) {
                }
            }
        }

        return $messages;
    }
}