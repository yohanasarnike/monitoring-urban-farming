<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kalender Jadwal Perawatan - Urban Farming</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        * {
            box-sizing: border-box;
            font-family: 'Poppins', sans-serif;
            margin: 0;
            padding: 0;
        }

        body {
            background-color: #f4f7f4;
            color: #2d3748;
        }

        /* Navbar */
        .navbar {
            background-color: #2d6a4f;
            color: white;
            padding: 18px 40px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.05);
        }

        .navbar h2 {
            font-size: 20px;
            font-weight: 600;
        }

        .navbar a {
            color: white;
            text-decoration: none;
            font-weight: 500;
            font-size: 14px;
            transition: color 0.2s;
        }

        .navbar a:hover {
            color: #95d5b2;
        }

        /* Layout Utama Web (Grid Kalender & Jadwal) */
        .main-container {
            max-width: 1200px;
            margin: 30px auto;
            padding: 0 20px;
        }

        .calendar-layout {
            display: grid;
            grid-template-columns: 400px 1fr;
            gap: 30px;
            align-items: start;
        }

        @media (max-width: 992px) {
            .calendar-layout {
                grid-template-columns: 1fr;
            }
        }

        /* Kotak Kalender Estetik */
        .calendar-card {
            background: #ffffff;
            border-radius: 24px;
            padding: 25px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.04);
            border: 1px solid #edf2ed;
        }

        .calendar-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 20px;
        }

        .calendar-header h3 {
            font-size: 18px;
            font-weight: 700;
            color: #1b4332;
        }

        .calendar-grid {
            display: grid;
            grid-template-columns: repeat(7, 1fr);
            gap: 8px;
            text-align: center;
        }

        .calendar-day-name {
            font-size: 12px;
            font-weight: 600;
            color: #888;
            padding-bottom: 8px;
        }

        .calendar-date {
            aspect-ratio: 1;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            border-radius: 12px;
            font-size: 13px;
            font-weight: 600;
            color: #333;
            background: #f9faf9;
            cursor: pointer;
            transition: all 0.2s;
            position: relative;
            text-decoration: none;
            border: 1px solid transparent;
        }

        .calendar-date:hover {
            background: #e8f5e9;
            border-color: #52b788;
        }

        .calendar-date.active {
            background: #f4a261;
            color: white;
            box-shadow: 0 4px 12px rgba(244, 162, 97, 0.4);
        }

        .calendar-date.other-month {
            color: #ccc;
            background: transparent;
        }

        .event-dot {
            width: 4px;
            height: 4px;
            background-color: #52b788;
            border-radius: 50%;
            margin-top: 3px;
        }

        .calendar-date.active .event-dot {
            background-color: white;
        }

        /* Filter Pilihan Tanaman di Sidebar */
        .filter-section {
            margin-top: 25px;
            padding-top: 20px;
            border-top: 1px solid #edf2ed;
        }

        .filter-section h4 {
            font-size: 14px;
            font-weight: 600;
            color: #1b4332;
            margin-bottom: 12px;
        }

        .plant-pill-list {
            display: flex;
            flex-wrap: wrap;
            gap: 8px;
        }

        .plant-pill {
            padding: 6px 12px;
            background: #f4f7f4;
            border-radius: 20px;
            font-size: 12px;
            color: #555;
            text-decoration: none;
            border: 1px solid #e2e8e2;
            transition: all 0.2s;
        }

        .plant-pill:hover,
        .plant-pill.active {
            background: #2d6a4f;
            color: white;
            border-color: #2d6a4f;
        }

        /* Kolom Kanan: Daftar Jadwal Harian (Timeline) */
        .schedule-card-container {
            background: #ffffff;
            border-radius: 24px;
            padding: 30px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.04);
            border: 1px solid #edf2ed;
        }

        .schedule-card-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 25px;
            padding-bottom: 15px;
            border-bottom: 1px solid #f0f4f0;
        }

        .schedule-card-header h3 {
            font-size: 20px;
            color: #1b4332;
            font-weight: 700;
        }

        .schedule-list {
            display: flex;
            flex-direction: column;
            gap: 20px;
        }

        .schedule-item {
            padding: 20px;
            background: #fafcf9;
            border-radius: 16px;
            border: 1px solid #eef2ef;
            position: relative;
            overflow: hidden;
            transition: transform 0.2s, box-shadow 0.2s;
        }

        .schedule-item:hover {
            box-shadow: 0 6px 20px rgba(0, 0, 0, 0.05);
            background: #ffffff;
        }

        .schedule-item::before {
            content: '';
            position: absolute;
            left: 0;
            top: 0;
            bottom: 0;
            width: 6px;
        }

        .schedule-item.watering::before {
            background-color: #52b788;
        }

        .schedule-item.fertilizer::before {
            background-color: #f4a261;
        }

        .schedule-item.harvest::before {
            background-color: #e76f51;
        }

        .schedule-top-info {
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
            margin-bottom: 12px;
        }

        .schedule-left {
            display: flex;
            align-items: flex-start;
            gap: 14px;
        }

        .schedule-icon {
            width: 40px;
            height: 40px;
            border-radius: 10px;
            background: #e8f5e9;
            display: flex;
            align-items: center;
            justify-content: center;
            color: #2d6a4f;
            font-size: 16px;
            flex-shrink: 0;
        }

        .schedule-details h4 {
            font-size: 14px;
            font-weight: 600;
            color: #2d3748;
            margin-bottom: 4px;
        }

        .schedule-details p {
            font-size: 12px;
            color: #666;
        }

        .schedule-right {
            text-align: right;
            flex-shrink: 0;
        }

        .schedule-time {
            font-size: 12px;
            font-weight: 600;
            color: #1b4332;
        }

        .schedule-date {
            font-size: 11px;
            color: #888;
        }

        /* Style Form Update Harian di Dalam Item Jadwal */
        .update-form-box {
            margin-top: 15px;
            padding-top: 15px;
            border-top: 1px dashed #d8e2dc;
        }

        .form-row-custom {
            display: grid;
            grid-template-columns: 1fr 1fr 1fr;
            gap: 10px;
            margin-bottom: 10px;
        }

        @media (max-width: 768px) {
            .form-row-custom {
                grid-template-columns: 1fr;
            }
        }

        .form-group-custom label {
            font-size: 11px;
            font-weight: 600;
            color: #444;
            display: block;
            margin-bottom: 3px;
        }

        .form-control-sm-custom {
            width: 100%;
            padding: 6px 10px;
            font-size: 12px;
            border: 1px solid #cbd5e1;
            border-radius: 8px;
            background: #fff;
        }

        .form-textarea-custom {
            width: 100%;
            padding: 6px 10px;
            font-size: 12px;
            border: 1px solid #cbd5e1;
            border-radius: 8px;
            background: #fff;
            resize: vertical;
            height: 38px;
        }

        .form-footer-action {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-top: 8px;
        }

        .btn-save-update {
            background-color: #2d6a4f;
            color: white;
            border: none;
            padding: 6px 14px;
            font-size: 12px;
            font-weight: 500;
            border-radius: 8px;
            cursor: pointer;
            transition: background 0.2s;
        }

        .btn-save-update:hover {
            background-color: #1b4332;
        }

        .empty-state {
            text-align: center;
            padding: 50px 20px;
            color: #777;
        }

        /* Gaya untuk jadwal yang sudah selesai dikerjakan */
        .schedule-item.completed-item {
            background-color: #f0fdf4 !important;
            border-color: #bbf7d0 !important;
        }

        .schedule-item.completed-item .schedule-details h4 {
            color: #166534;
            text-decoration: line-through;
        }
    </style>
</head>

<body>

    <!-- Navbar -->
    <div class="navbar">
        <h2>Sistem Monitoring Urban Farming</h2>
        <!-- Menggunakan url()->previous() agar dinamis kembali ke halaman sebelumnya (Notifikasi/Dashboard) -->
        <a href="{{ url()->previous() }}"><i class="fa-solid fa-arrow-left"></i> Kembali</a>
    </div>

    <!-- Main Container -->
    <div class="main-container">
        <div class="calendar-layout">

            <!-- Kolom Kiri: Widget Kalender & Filter -->
            <div class="calendar-card">
                @php
                $month = request('month', \Carbon\Carbon::now()->month);
                $year = request('year', \Carbon\Carbon::now()->year);
                $currentCalendarDate = \Carbon\Carbon::createFromDate($year, $month, 1);
                $prevMonth = $currentCalendarDate->copy()->subMonth();
                $nextMonth = $currentCalendarDate->copy()->addMonth();
                @endphp

                <div class="calendar-header">
                    <h3>{{ $currentCalendarDate->translatedFormat('F Y') }}</h3>
                    <div style="display: flex; gap: 8px; align-items: center;">
                        <a href="{{ route('jadwal.index', array_merge(request()->all(), ['month' => $prevMonth->month, 'year' => $prevMonth->year])) }}"
                            style="width: 28px; height: 28px; display: flex; align-items: center; justify-content: center; background: #f0f4f0; border-radius: 50%; color: #333; text-decoration: none;">
                            <i class="fa-solid fa-chevron-left" style="font-size: 11px;"></i>
                        </a>
                        <a href="{{ route('jadwal.index', array_merge(request()->all(), ['month' => $nextMonth->month, 'year' => $nextMonth->year])) }}"
                            style="width: 28px; height: 28px; display: flex; align-items: center; justify-content: center; background: #f0f4f0; border-radius: 50%; color: #333; text-decoration: none;">
                            <i class="fa-solid fa-chevron-right" style="font-size: 11px;"></i>
                        </a>
                    </div>
                </div>

                <!-- Grid Kalender -->
                <div class="calendar-grid">
                    <div class="calendar-day-name">Mo</div>
                    <div class="calendar-day-name">Tu</div>
                    <div class="calendar-day-name">We</div>
                    <div class="calendar-day-name">Th</div>
                    <div class="calendar-day-name">Fr</div>
                    <div class="calendar-day-name">Sa</div>
                    <div class="calendar-day-name">Su</div>

                    @php
                    $daysInMonth = $currentCalendarDate->daysInMonth;
                    $firstDayOfWeek = $currentCalendarDate->copy()->startOfMonth()->dayOfWeekIso;
                    $selectedDate = request('tanggal');
                    @endphp

                    @for ($i = 1; $i < $firstDayOfWeek; $i++)
                        <div class="calendar-date other-month"></div>
                    @endfor

                    @for ($day = 1; $day <= $daysInMonth; $day++)
                        @php
                        $currentLoopDate=$currentCalendarDate->copy()->setDate($year, $month, $day)->format('Y-m-d');
                        $isActive = ($selectedDate == $currentLoopDate);
                        $hasEvent = in_array($currentLoopDate, $tanggalAdaJadwal ?? []);
                        @endphp

                        <a href="{{ route('jadwal.index', array_merge(request()->all(), ['tanggal' => $currentLoopDate])) }}"
                            class="calendar-date {{ $isActive ? 'active' : '' }}">
                            <span>{{ $day }}</span>
                            @if($hasEvent)
                            <span class="event-dot"></span>
                            @endif
                        </a>
                    @endfor
                </div>

                <!-- Filter Berdasarkan Tanaman -->
                <div class="filter-section">
                    <h4>🌱 Filter Berdasarkan Tanaman</h4>
                    <div class="plant-pill-list">
                        <a href="{{ route('jadwal.index', array_merge(request()->except('id'), ['id' => null])) }}"
                            class="plant-pill {{ !request('id') ? 'active' : '' }}">
                            Semua Tanaman
                        </a>
                        @foreach($daftarTanaman as $tanaman)
                        <a href="{{ route('jadwal.index', array_merge(request()->all(), ['id' => $tanaman->id_tanaman_ditanam])) }}"
                            class="plant-pill {{ request('id') == $tanaman->id_tanaman_ditanam ? 'active' : '' }}">
                            {{ $tanaman->jenis_bibit }}
                        </a>
                        @endforeach
                    </div>
                </div>
            </div>

            <!-- Kolom Kanan: Daftar Jadwal & Form Update Harian -->
            <div class="schedule-card-container">
                <div class="schedule-card-header">
                    <div>
                        <h3>Aktivitas Perawatan</h3>
                        <p style="font-size: 13px; color: #666; margin-top: 4px;">
                            @if(request('tanggal'))
                            Menampilkan jadwal untuk tanggal: <b>{{ \Carbon\Carbon::parse(request('tanggal'))->translatedFormat('d F Y') }}</b>
                            @else
                            Menampilkan seluruh jadwal perawatan (Klik tanggal di kalender untuk memfilter).
                            @endif
                        </p>
                    </div>
                    @if(request('tanggal') || request('id') || request('month'))
                    <a href="{{ route('jadwal.index') }}" style="font-size: 12px; color: #e76f51; text-decoration: none; font-weight: 600;">
                        <i class="fa-solid fa-rotate-right"></i> Reset Filter
                    </a>
                    @endif
                </div>

                <div class="schedule-list">
                    @forelse($jadwalPerawatan as $jadwal)
                    @php
                    $tipeKelas = 'watering';
                    $iconClass = 'fa-droplet';
                    if(!empty($jadwal->jenis_pupuk) && $jadwal->jenis_pupuk !== '-') {
                    $tipeKelas = 'fertilizer';
                    $iconClass = 'fa-bottle-droplet';
                    }
                    if($jadwal->kondisi == 'Siap Panen') {
                    $tipeKelas = 'harvest';
                    $iconClass = 'fa-basket-shopping';
                    }
                    @endphp

                    <div class="schedule-item {{ $tipeKelas }} {{ $jadwal->status == 'Selesai' ? 'completed-item' : '' }}">
                        <div class="schedule-top-info">
                            <div class="schedule-left">
                                <div class="schedule-icon">
                                    <i class="fa-solid {{ $iconClass }}"></i>
                                </div>
                                <div class="schedule-details">
                                    <h4>{{ $jadwal->keterangan }}</h4>
                                    <p>
                                        Tanaman: <b>{{ optional($jadwal->tanaman)->jenis_bibit ?? 'Tanaman' }}</b>
                                        @if($jadwal->suhu && $jadwal->status == 'Selesai')
                                        | Suhu: {{ $jadwal->suhu }}°C | pH: {{ $jadwal->pH_tanaman }} | Kelembapan: {{ $jadwal->kelembapan }}%
                                        @else
                                        | <span style="color: #e76f51; font-style: italic;">Belum diupdate (Menunggu input pengguna)</span>
                                        @endif
                                    </p>
                                </div>
                            </div>

                            @if($jadwal->status == 'Selesai')
                            <span style="background: #dcfce7; color: #166534; padding: 3px 8px; font-size: 11px; font-weight: 600; border-radius: 6px;">
                                <i class="fa-solid fa-check-circle"></i> Selesai
                            </span>
                            @else
                            <span style="background: #fef9c3; color: #854d0e; padding: 3px 8px; font-size: 11px; font-weight: 600; border-radius: 6px;">
                                Pending
                            </span>
                            @endif
                            <div class="schedule-right">
                                <div class="schedule-time">⏰ {{ $jadwal->waktu_perawatan ?? '08:00' }}</div>
                                <div class="schedule-date">🗓️ {{ \Carbon\Carbon::parse($jadwal->tanggal_perawatan)->format('d M Y') }}</div>
                            </div>
                        </div>

                        <!-- FORM UPDATE HARIAN -->
                        <div class="update-form-box">
                            <form action="{{ route('perawatan.update', $jadwal->getKey()) }}" method="POST">
                                @csrf
                                <div style="display: grid; grid-template-columns: repeat(2, 1fr); gap: 10px; margin-bottom: 10px;">
                                    <div>
                                        <label style="font-size: 11px; font-weight: 600;">Suhu (°C):</label>
                                        <input type="number" step="0.1" name="suhu" class="form-control-sm-custom" value="{{ $jadwal->suhu }}">
                                    </div>
                                    <div>
                                        <label style="font-size: 11px; font-weight: 600;">pH Tanah:</label>
                                        <input type="number" step="0.1" name="pH_tanaman" class="form-control-sm-custom" value="{{ $jadwal->pH_tanaman }}">
                                    </div>
                                    <div>
                                        <label style="font-size: 11px; font-weight: 600;">Tinggi (cm):</label>
                                        <input type="number" step="0.1" name="tinggi_tanaman" class="form-control-sm-custom" value="{{ $jadwal->tinggi_tanaman }}">
                                    </div>
                                    <div>
                                        <label style="font-size: 11px; font-weight: 600;">Kondisi:</label>
                                        <select name="kondisi" class="form-control-sm-custom">
                                            <option value="Sehat" {{ $jadwal->kondisi == 'Sehat' ? 'selected' : '' }}>Sehat</option>
                                            <option value="Terkena Hama" {{ $jadwal->kondisi == 'Terkena Hama' ? 'selected' : '' }}>Terkena Hama</option>
                                        </select>
                                    </div>
                                </div>

                                <div style="margin-bottom: 10px;">
                                    <label style="font-size: 11px; font-weight: 600;">Catatan / Keterangan:</label>
                                    <input type="text" name="catatan_harian" class="form-control-sm-custom" value="{{ $jadwal->catatan_harian }}" placeholder="Misal: Sudah disiram dan diberi pupuk tambahan...">
                                </div>

                                <div style="display: flex; justify-content: space-between; align-items: center;">
                                    <label style="font-size: 12px; font-weight: 500; color: #2d6a4f; cursor: pointer;">
                                        <input type="checkbox" name="status" value="Selesai" {{ $jadwal->status == 'Selesai' ? 'checked' : '' }}> Selesai Dikerjakan
                                    </label>
                                    <button type="submit" class="btn-save-update">Simpan Update</button>
                                </div>
                            </form>
                        </div>
                    </div>
                    @empty
                    <div class="empty-state">
                        <i class="fa-solid fa-calendar-xmark" style="font-size: 40px; color: #52b788; margin-bottom: 12px;"></i>
                        <p>Tidak ada jadwal perawatan pada tanggal atau filter yang dipilih.</p>
                    </div>
                    @endforelse
                </div>
            </div>

        </div>
    </div>

</body>

</html>