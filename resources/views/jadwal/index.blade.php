<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Jadwal Perawatan Tanaman - Urban Farming</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        * { box-sizing: border-box; font-family: 'Poppins', sans-serif; margin: 0; padding: 0; }
        body { background-color: #f4f7f4; color: #333; }
        
        .navbar {
            background-color: #2d6a4f;
            color: white;
            padding: 18px 40px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
        }
        .navbar h2 { font-size: 20px; font-weight: 600; }
        .navbar a { color: white; text-decoration: none; font-weight: 500; font-size: 15px; }
        .navbar a:hover { color: #95d5b2; }

        .main-container { max-width: 1200px; margin: 40px auto; padding: 0 20px; }

        /* Grid Kartu Minimalis */
        .plant-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(280px, 320px));
            gap: 25px;
        }
        .plant-card {
            background: #ffffff;
            border-radius: 16px;
            padding: 35px 25px;
            text-align: center;
            text-decoration: none;
            color: #333;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.03);
            border: 1px solid #eef2ef;
            transition: transform 0.2s ease, box-shadow 0.2s ease;
            display: flex;
            flex-direction: column;
            align-items: center;
        }
        .plant-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 8px 25px rgba(0, 0, 0, 0.08);
            border-color: #52b788;
        }
        .icon-circle {
            width: 75px; height: 75px;
            background-color: #e8f5e9;
            border-radius: 50%;
            display: flex; align-items: center; justify-content: center;
            margin-bottom: 20px; color: #2d6a4f; font-size: 28px;
        }
        .plant-card h3 { font-size: 22px; font-weight: 600; color: #1b4332; margin-bottom: 12px; }
        .plant-card p { font-size: 13px; color: #666; line-height: 1.5; }

        /* Tampilan Detail Jadwal (Tabel) ketika Kartu Diklik */
        .detail-header {
            display: flex; justify-content: space-between; align-items: center; margin-bottom: 25px;
        }
        .btn-back {
            background: #e0e0e0; padding: 8px 16px; border-radius: 8px; text-decoration: none; color: #333; font-size: 13px; font-weight: 500;
        }
        .btn-back:hover { background: #d0d0d0; }
        
        .table-card { background: #ffffff; border-radius: 12px; box-shadow: 0 4px 12px rgba(0,0,0,0.05); overflow: hidden; }
        table { width: 100%; border-collapse: collapse; text-align: left; font-size: 14px; }
        thead tr { background-color: #2d6a4f; color: #ffffff; }
        th, td { padding: 14px 16px; }
        tbody tr { border-bottom: 1px solid #eee; }
        tbody tr:hover { background-color: #fafafa; }
        .empty-state { grid-column: 1 / -1; background: white; padding: 50px; border-radius: 16px; text-align: center; color: #777; }
    </style>
</head>
<body>

    <div class="navbar">
        <h2>Jadwal Perawatan Tanaman</h2>
        <a href="{{ url('/dashboard') }}">Dashboard</a>
    </div>

    <div class="main-container">
        
        @if(is_null($id))
            <!-- Kondisi 1: Menampilkan Daftar Kartu Tanaman -->
            <div style="margin-bottom: 25px;">
                <h1 style="font-size: 24px; color: #1b4332; margin-bottom: 5px;">Pilih Tanaman</h1>
                <p style="font-size: 14px; color: #666;">Klik salah satu kartu tanaman di bawah untuk melihat jadwal perawatan lengkapnya.</p>
            </div>

            <div class="plant-grid">
                @forelse($tanamanAktif as $tanaman)
                    <a href="{{ route('jadwal.index', $tanaman->id_tanaman_ditanam) }}" class="plant-card">
                        <div class="icon-circle">
                            <i class="fa-solid fa-seedling"></i>
                        </div>
                        <h3>{{ $tanaman->jenis_bibit }}</h3>
                        <p>Lokasi: {{ $tanaman->lokasi_tanam }}<br>Kelola jadwal penyiraman & pemupukan.</p>
                    </a>
                @empty
                    <div class="empty-state">
                        <i class="fa-solid fa-leaf" style="font-size: 40px; color: #2d6a4f; margin-bottom: 15px;"></i>
                        <p>Belum ada tanaman yang terdaftar. Tambahkan tanaman baru melalui dashboard!</p>
                    </div>
                @endforelse
            </div>

        @else
            <!-- Kondisi 2: Menampilkan Tabel Jadwal Perawatan Tanaman yang Dipilih -->
            <div class="detail-header">
                <div>
                    <h1 style="font-size: 24px; color: #2d6a4f; margin-bottom: 5px;">
                        🌿 Jadwal Perawatan: {{ $tanamanPilih->jenis_bibit ?? 'Tanaman' }}
                    </h1>
                    <p style="color: #666; font-size: 14px;">Lokasi: {{ $tanamanPilih->lokasi_tanam ?? '-' }} | Tanggal Tanam: {{ \Carbon\Carbon::parse($tanamanPilih->tanggal_tanam)->format('d M Y') }}</p>
                </div>
                <a href="{{ route('jadwal.index') }}" class="btn-back">
                    ← Kembali ke Pilih Tanaman
                </a>
            </div>

            <div class="table-card">
                <table>
                    <thead>
                        <tr>
                            <th>Tanggal</th>
                            <th>Waktu</th>
                            <th>Kondisi Lingkungan</th>
                            <th>Pupuk</th>
                            <th>Keterangan / Aktivitas</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($jadwalPerawatan as $jadwal)
                            <tr>
                                <td style="font-weight: bold; color: #2d6a4f;">
                                    🗓️ {{ \Carbon\Carbon::parse($jadwal->tanggal_perawatan)->format('d M Y') }}
                                </td>
                                <td>⏰ {{ $jadwal->waktu_perawatan ?? '-' }}</td>
                                <td style="color: #555;">
                                    Suhu: {{ $jadwal->suhu }}°C | pH: {{ $jadwal->pH_tanaman }} | Kelembapan: {{ $jadwal->kelembapan }}%
                                </td>
                                <td>{{ $jadwal->jenis_pupuk ?? '-' }}</td>
                                <td style="color: #333;">{{ $jadwal->keterangan }}</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" style="padding: 30px; text-align: center; color: #888;">
                                    Belum ada jadwal perawatan tercatat untuk tanaman ini.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        @endif

    </div>

</body>
</html>