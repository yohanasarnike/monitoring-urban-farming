<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Monitoring Tanaman | UrbanFarming</title>

    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&family=EB+Garamond:wght@700;800&display=swap" rel="stylesheet">

    <link rel="stylesheet"
        href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Poppins', sans-serif;
        }

        body {
            background-image: url('/img/bg.png');
            background-size: cover;
            background-position: center;
            background-repeat: no-repeat;
            background-attachment: fixed;
        }

        .container {
            width: 100%;
            max-width: 1200px;
            margin: 0 auto;
            padding: 30px 35px;
        }

        /* HEADER */
        .page-header {
            position: relative;
            background: linear-gradient(120deg, #2d7054, #4db68c);
            border-radius: 18px;
            padding: 25px 30px;
            color: white;
            margin-bottom: 25px;
            overflow: hidden;
        }

        .header-main {
            display: flex;
            align-items: center;
            gap: 18px;
            position: relative;
            z-index: 2;
        }

        .back-button {
            width: 48px;
            height: 48px;
            flex-shrink: 0;
            border: 1px solid rgba(255, 255, 255, .3);
            background: rgba(255, 255, 255, .17);
            color: white;
            border-radius: 13px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 23px;
            text-decoration: none;
            transition: .2s;
        }

        .back-button:hover {
            background: rgba(255, 255, 255, .3);
        }

        .header-content h1 {
            font-size: 32px;
            margin-bottom: 4px;
            font-weight: 500;
            line-height: 1.25;
        }

        .header-content p {
            font-size: 13px;
            font-weight: 100;
            line-height: 1.5;
        }

        .page-header::after {
            content: "";
            position: absolute;
            width: 150px;
            height: 150px;
            border-radius: 50%;
            background: rgba(255, 255, 255, 0.08);
            right: -45px;
            top: -80px;
        }

        /* NOTIFIKASI */
        .alert-success,
        .alert-error {
            padding: 12px 15px;
            margin-bottom: 15px;
            border-radius: 9px;
            font-size: 13px;
            font-weight: 700;
        }

        .alert-success {
            color: #27633e;
            background: #e8f5eb;
            border: 1px solid #c9e6d0;
        }

        .alert-error {
            color: #a52c2c;
            background: #fdeaea;
            border: 1px solid #f3cccc;
        }

        /* PROFIL PENGGUNA */
        .profile-card {
            background: white;
            width: 100%;
            max-width: 400px;
            margin: 0 auto 30px;
            padding: 18px 20px;
            border-radius: 18px;
            display: flex;
            flex-direction: column;
            align-items: center;
            text-align: center;
            gap: 8px;
            box-shadow: 0 4px 15px rgba(40, 93, 50, 0.05);
        }

        .profile-avatar {
            width: 48px;
            height: 48px;
            border-radius: 14px;
            background: #e2f2e6;
            color: #2d7054;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 21px;
            font-weight: 800;
        }

        .profile-info h2 {
            font-size: 17px;
            color: #285d32;
        }

        .profile-info p {
            font-size: 12px;
            color: #87958a;
        }

        /* JUDUL TANAMAN */
        .section-heading {
            width: 100%;
            max-width: 850px;
            margin: 0 auto 15px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            gap: 12px;
        }

        .section-heading h2 {
            font-size: 20px;
            color: #285d32;
            font-weight: 800;
        }

        .plant-count {
            background: #e2f2e6;
            color: #2d7054;
            padding: 7px 14px;
            border-radius: 20px;
            font-size: 12px;
            font-weight: 800;
            white-space: nowrap;
        }

        /* PEMILIHAN TANAMAN */
        .plant-selector-wrap {
            width: 100%;
            max-width: 850px;
            margin: 0 auto 20px;
            background: white;
            border: 1px solid #e2ebe1;
            border-radius: 15px;
            padding: 18px 20px;
            box-shadow: 0 4px 15px rgba(40, 93, 50, 0.04);
        }

        .plant-selector-label {
            display: block;
            color: #285d32;
            font-size: 14px;
            font-weight: 800;
            margin-bottom: 8px;
        }

        .plant-selector {
            width: 100%;
            padding: 12px 14px;
            border: 1px solid #cbdccb;
            border-radius: 10px;
            background: #f8fbf6;
            color: #294c37;
            font-family: 'Nunito', sans-serif;
            font-size: 14px;
            font-weight: 700;
            outline: none;
            cursor: pointer;
        }

        .plant-selector:focus {
            border-color: #398568;
            background: white;
            box-shadow: 0 0 0 3px rgba(57, 133, 104, 0.1);
        }

        .plant-selector-hint {
            margin-top: 8px;
            color: #87958a;
            font-size: 12px;
        }

        .selection-message {
            width: 100%;
            max-width: 850px;
            margin: 0 auto 20px;
            padding: 18px;
            background: #e8f5eb;
            border: 1px solid #c9e6d0;
            border-radius: 12px;
            color: #397052;
            text-align: center;
            font-size: 13px;
            font-weight: 700;
        }

        /* DAFTAR TANAMAN */
        .plant-list {
            width: 100%;
            max-width: 850px;
            margin: 0 auto;
            display: flex;
            flex-direction: column;
            gap: 22px;
        }

        .plant-card {
            background: #e7f4dc;
            border: 1px solid #9ebd80;
            border-radius: 17px;
            padding: 20px;
        }

        /* KONSEP 2: INFORMASI DUA SISI */
        .plant-summary {
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 20px;
            margin-bottom: 20px;
        }

        .plant-left {
            display: flex;
            align-items: center;
            gap: 16px;
            flex: 1;
            min-width: 0;
        }

        /* IKON TANAMAN */
        .plant-image {
            width: 85px;
            height: 85px;
            min-width: 85px;
            border-radius: 15px;
            background: #d8eacb;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .plant-image span {
            font-size: 39px;
            line-height: 1;
        }

        .plant-details {
            min-width: 0;
        }

        .plant-details h3 {
            color: #477b32;
            font-size: 21px;
            font-weight: 800;
            margin-bottom: 6px;
        }

        .plant-subtitle {
            color: #64864b;
            font-size: 12px;
            margin-bottom: 5px;
        }

        .plant-date {
            color: #64864b;
            font-size: 12px;
        }

        /* INFORMASI SEBELAH KANAN */
        .plant-right {
            min-width: 115px;
            padding-left: 20px;
            border-left: 1px solid #c9dcb9;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            text-align: center;
            gap: 7px;
        }

        .plant-age {
            color: #477b32;
            font-size: 34px;
            font-weight: 800;
            line-height: 1;
        }

        .plant-age-label {
            color: #64864b;
            font-size: 11px;
            font-weight: 700;
        }

        /* BADGE KONDISI */
        .status-badge {
            display: inline-block;
            padding: 6px 12px;
            border-radius: 20px;
            font-size: 10px;
            font-weight: 800;
            white-space: nowrap;
        }

        .status-baik {
            background: #dcfce7;
            color: #15803d;
        }

        .status-cukup {
            background: #dbeafe;
            color: #1d4ed8;
        }

        .status-perhatian {
            background: #fef3c7;
            color: #d97706;
        }

        .status-kurang {
            background: #fee2e2;
            color: #dc2626;
        }

        .status-panen {
            background: #bbf7d0;
            color: #166534;
        }

        .status-default {
            background: #eeeeee;
            color: #666666;
        }

        /* TABEL PERKEMBANGAN */
        .growth-section {
            width: 100%;
            margin: 0 auto;
        }

        .growth-section h3 {
            text-align: center;
            color: #31536b;
            font-size: 19px;
            font-weight: 800;
            margin-bottom: 12px;
        }

        .growth-table {
            width: 100%;
            border-collapse: collapse;
            background: white;
            border-radius: 12px;
            overflow: hidden;
        }

        .growth-table thead {
            background: #398568;
            color: white;
        }

        .growth-table th {
            padding: 13px 10px;
            font-size: 12px;
            text-align: center;
        }

        .growth-table td {
            padding: 11px 10px;
            text-align: center;
            font-size: 12px;
            color: #294c37;
            border-bottom: 1px solid #e5ece4;
        }

        /* TOMBOL DETAIL MINGGU */
        .week-toggle {
            width: 100%;
            border: none;
            background: transparent;
            color: #285d32;
            font-family: 'Nunito', sans-serif;
            font-size: 12px;
            font-weight: 800;
            cursor: pointer;
        }

        .week-toggle:hover {
            color: #398568;
        }

        .week-toggle .arrow {
            display: inline-block;
            margin-left: 5px;
            transition: transform 0.2s;
        }

        .week-toggle.active .arrow {
            transform: rotate(180deg);
        }

        .week-detail {
            display: none;
        }

        .week-detail.show {
            display: table-row;
        }

        .week-detail td {
            background: #f4f9f1;
            padding: 15px 20px;
            text-align: left;
        }

        /* DETAIL MONITORING */
        .detail-content {
            display: grid;
            grid-template-columns: repeat(3, minmax(0, 1fr));
            gap: 12px;
        }

        .detail-item {
            background: white;
            padding: 13px;
            border-radius: 9px;
            border: 1px solid #e1ebdd;
            min-width: 0;
        }

        .detail-item strong {
            display: block;
            color: #64864b;
            font-size: 12px;
            margin-bottom: 7px;
        }

        .detail-item span {
            color: #294c37;
            font-size: 14px;
            font-weight: 800;
            overflow-wrap: anywhere;
        }

        /* FORM ADMIN */
        .admin-edit-form {
            width: 100%;
        }

        .detail-item label {
            display: block;
            color: #64864b;
            font-size: 12px;
            font-weight: 800;
            margin-bottom: 7px;
        }

        /* DROPDOWN KONDISI */
        .detail-item select {
            display: block;
            width: 100%;
            padding: 10px 12px;
            border: 1px solid #dce8d8;
            border-radius: 8px;
            outline: none;
            background: #f8fbf6;
            color: #294c37;
            font-family: 'Nunito', sans-serif;
            font-size: 14px;
            font-weight: 800;
            cursor: pointer;
        }

        .detail-item select:focus {
            border-color: #398568;
            background: white;
        }

        /* TEXTAREA CATATAN */
        .detail-item textarea {
            display: block;
            width: 100%;
            min-height: 45px;
            padding: 0;
            border: none;
            outline: none;
            resize: vertical;
            background: transparent;
            color: #294c37;
            font-family: 'Nunito', sans-serif;
            font-size: 14px;
            font-weight: 800;
            line-height: 1.5;
        }

        .detail-item textarea:focus {
            border-bottom: 1px solid #398568;
        }

        .detail-item textarea::placeholder {
            color: #a3afa5;
            font-weight: 500;
        }

        .detail-item:focus-within {
            border-color: #398568;
        }

        /* TOMBOL SIMPAN */
        .save-wrapper {
            grid-column: 1 / -1;
            margin-top: 3px;
        }

        .btn-save {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
            padding: 12px 25px;
            border: none;
            border-radius: 9px;
            background: #397f66;
            color: white;
            font-family: 'Nunito', sans-serif;
            font-size: 14px;
            font-weight: 800;
            cursor: pointer;
            transition: 0.2s;
        }

        .btn-save:hover {
            background: #2d6853;
            transform: translateY(-1px);
        }

        /* DATA KOSONG */
        .empty-growth {
            color: #87958a !important;
            padding: 20px !important;
            text-align: center !important;
        }

        .empty-state {
            max-width: 850px;
            margin: 0 auto;
            background: white;
            border-radius: 18px;
            padding: 40px 20px;
            text-align: center;
        }

        .empty-icon {
            font-size: 40px;
            margin-bottom: 10px;
        }

        .empty-state h3 {
            color: #285d32;
            margin-bottom: 6px;
        }

        .empty-state p {
            color: #87958a;
            font-size: 13px;
        }

        /* RESPONSIVE DESKTOP 1024PX */
        @media screen and (max-width: 1024px) {
            .container {
                padding: 22px 28px;
            }

            .plant-list,
            .section-heading,
            .plant-selector-wrap,
            .selection-message {
                max-width: 850px;
            }

            .plant-card {
                padding: 18px;
            }

        }

        /* RESPONSIVE HP */
        @media screen and (max-width: 700px) {
            .container {
                padding: 18px 14px;
            }

            .page-header {
                padding: 20px;
            }

            .header-content h1 {
                font-size: 22px;
            }

            .header-content p {
                font-size: 11px;
            }

            .plant-card {
                padding: 15px;
            }

            .plant-selector-wrap {
                padding: 15px;
            }

            .plant-selector {
                font-size: 13px;
            }

            .plant-summary {
                gap: 15px;
            }

            .plant-left {
                gap: 11px;
            }

            .plant-image {
                width: 62px;
                height: 62px;
                min-width: 62px;
                border-radius: 12px;
            }

            .plant-image span {
                font-size: 30px;
            }

            .plant-details h3 {
                font-size: 17px;
            }

            .plant-subtitle,
            .plant-date {
                font-size: 10px;
            }

            .plant-right {
                min-width: 80px;
                padding-left: 12px;
                gap: 6px;
            }

            .plant-age {
                font-size: 27px;
            }

            .plant-age-label {
                font-size: 10px;
            }

            .status-badge {
                padding: 5px 8px;
                font-size: 9px;
            }

            .detail-content {
                grid-template-columns: repeat(2, minmax(0, 1fr));
            }

            .detail-item:nth-child(4),
            .detail-item:nth-child(5),
            .save-wrapper {
                grid-column: 1 / -1;
            }

            .week-detail td {
                padding: 12px 10px;
            }

            .growth-table th,
            .growth-table td {
                padding: 9px 6px;
                font-size: 11px;
            }

            .btn-save {
                width: 100%;
            }
        }
    </style>
</head>

<body>

    <div class="container">

        <!-- HEADER -->
        <div class="page-header">
            <div class="header-main">

                <a href="{{ route('admin.monitoring') }}" class="back-button">
                    <i class="fa-solid fa-arrow-left"></i>
                </a>

                <div class="header-content">
                    <h1>Detail Monitoring</h1>
                    <p>Pantau perkembangan tanaman pengguna UrbanFarming.</p>
                </div>

            </div>
        </div>

        <!-- NOTIFIKASI -->
        @if (session('success'))
        <div class="alert-success">
            {{ session('success') }}
        </div>
        @endif

        @if (session('error'))
        <div class="alert-error">
            {{ session('error') }}
        </div>
        @endif

        @if ($errors->any())
        <div class="alert-error">
            @foreach ($errors->all() as $error)
            <div>{{ $error }}</div>
            @endforeach
        </div>
        @endif

        <!-- PROFIL PENGGUNA -->
        <div class="profile-card">

            <div class="profile-avatar">
                {{ strtoupper(substr($pengguna->username, 0, 1)) }}
            </div>

            <div class="profile-info">
                <h2>{{ $pengguna->username }}</h2>
            </div>

        </div>

        <!-- JUDUL DAFTAR TANAMAN -->
        <div class="section-heading">

            <h2>Tanaman Pengguna</h2>

            <span class="plant-count">
                {{ $tanaman->count() }} Tanaman
            </span>

        </div>

        @if ($tanaman->count() > 0)

        <!-- DROPDOWN HANYA MUNCUL JIKA TANAMAN LEBIH DARI SATU -->
        @if ($tanaman->count() > 1)

        <div class="plant-selector-wrap">

            <label for="plantSelector" class="plant-selector-label">
                Pilih Tanaman yang Ingin Dipantau
            </label>

            <select id="plantSelector" class="plant-selector">

                <option value="">
                    -- Tanaman yang akan dipantau --
                </option>

                @foreach ($tanaman as $item)
                <option value="{{ $item->id_tanaman_ditanam }}">
                    {{ $item->jenis_bibit }}
                    — {{ $item->jenis_lahan ?? 'Jenis lahan belum ditentukan' }}
                    — {{ $item->tanggal_tanam
                                    ? \Carbon\Carbon::parse($item->tanggal_tanam)->format('d M Y')
                                    : 'Tanggal belum tersedia' }}
                </option>
                @endforeach

            </select>
        </div>

        <div id="selectionMessage" class="selection-message">
            🌱 Silakan pilih tanaman yang ingin kamu lihat terlebih dahulu.
        </div>

        @endif

        <!-- DAFTAR TANAMAN -->
        <div class="plant-list">

            @foreach ($tanaman as $item)

            @php
            $latestPerkembangan = $item->perkembangan
            ->sortBy('minggu')
            ->last();

            $kondisiTerbaru = strtolower(
            trim($latestPerkembangan->kondisi ?? '')
            );

            $statusClassTerbaru = match ($kondisiTerbaru) {
            'baik' => 'status-baik',
            'cukup baik' => 'status-cukup',
            'perlu perhatian' => 'status-perhatian',
            'kurang baik' => 'status-kurang',
            'siap panen' => 'status-panen',
            default => 'status-default',
            };

            $umurTanaman = $item->tanggal_tanam
            ? \Carbon\Carbon::parse($item->tanggal_tanam)
            ->startOfDay()
            ->diffInDays(\Carbon\Carbon::today())
            : null;
            @endphp

            <div
                class="plant-card"
                data-plant-id="{{ $item->id_tanaman_ditanam }}"
                @if ($tanaman->count() > 1) hidden @endif>

                <!-- INFORMASI TANAMAN -->
                <div class="plant-summary">

                    <!-- SEBELAH KIRI -->
                    <div class="plant-left">

                        <div class="plant-image">
                            <span>🌱</span>
                        </div>

                        <div class="plant-details">

                            <h3>{{ $item->jenis_bibit }}</h3>

                            <p class="plant-subtitle">
                                {{ $item->jenis_lahan ?? 'Jenis lahan belum ditentukan' }}
                            </p>

                            <p class="plant-date">
                                Ditanam:
                                {{ $item->tanggal_tanam
                                            ? \Carbon\Carbon::parse($item->tanggal_tanam)->format('d M Y')
                                            : '-' }}
                            </p>

                        </div>

                    </div>

                    <!-- SEBELAH KANAN -->
                    <div class="plant-right">

                        <div class="plant-age">
                            {{ $umurTanaman ?? '-' }}
                        </div>

                        <div class="plant-age-label">
                            Hari
                        </div>

                        <span class="status-badge {{ $statusClassTerbaru }}">
                            {{ $latestPerkembangan->kondisi ?? 'Belum Dicek' }}
                        </span>

                    </div>

                </div>

                <!-- TABEL PERKEMBANGAN -->
                <div class="growth-section">

                    <h3>🌱 Tabel Perkembangan</h3>

                    <table class="growth-table">

                        <thead>
                            <tr>
                                <th>Minggu</th>
                                <th>Tinggi Tanaman</th>
                                <th>Kondisi</th>
                            </tr>
                        </thead>

                        <tbody>

                            @forelse ($item->perkembangan as $perkembangan)

                            @php
                            $kondisi = strtolower(
                            trim($perkembangan->kondisi ?? '')
                            );

                            $statusClass = match ($kondisi) {
                            'baik' => 'status-baik',
                            'cukup baik' => 'status-cukup',
                            'perlu perhatian' => 'status-perhatian',
                            'kurang baik' => 'status-kurang',
                            'siap panen' => 'status-panen',
                            default => 'status-default',
                            };
                            @endphp

                            <!-- BARIS RINGKASAN MINGGU -->
                            <tr>

                                <td>
                                    <button
                                        type="button"
                                        class="week-toggle"
                                        onclick="toggleWeek('week-{{ $item->id_tanaman_ditanam }}-{{ $perkembangan->minggu }}', this)">

                                        Minggu {{ $perkembangan->minggu }}

                                        <span class="arrow">▼</span>

                                    </button>
                                </td>

                                <td>
                                    {{ $perkembangan->tinggi_tanaman ?? '-' }} cm
                                </td>

                                <td>
                                    <span class="status-badge {{ $statusClass }}">
                                        {{ $perkembangan->kondisi ?: 'Belum Dicek (Terjadwal)' }}
                                    </span>
                                </td>

                            </tr>

                            <!-- DETAIL MONITORING MINGGU -->
                            <tr
                                id="week-{{ $item->id_tanaman_ditanam }}-{{ $perkembangan->minggu }}"
                                class="week-detail">

                                <td colspan="3">

                                    <form
                                        class="admin-edit-form"
                                        action="{{ route('admin.perawatan.update', $perkembangan->id_jadwal) }}"
                                        method="POST">

                                        @csrf
                                        @method('PUT')

                                        <div class="detail-content">

                                            <!-- TINGGI TANAMAN -->
                                            <div class="detail-item">

                                                <strong>Tinggi Tanaman</strong>

                                                <span>
                                                    {{ $perkembangan->tinggi_tanaman ?? '-' }} cm
                                                </span>

                                            </div>

                                            <!-- SUHU -->
                                            <div class="detail-item">

                                                <strong>Suhu</strong>

                                                <span>
                                                    {{ $perkembangan->suhu ?? '-' }} °C
                                                </span>

                                            </div>

                                            <!-- PH TANAH -->
                                            <div class="detail-item">

                                                <strong>pH Tanah</strong>

                                                <span>
                                                    {{ $perkembangan->ph ?? '-' }}
                                                </span>

                                            </div>

                                            <!-- DROPDOWN KONDISI -->
                                            <div class="detail-item">

                                                <label for="kondisi-{{ $perkembangan->id_jadwal }}">
                                                    Kondisi Tanaman
                                                </label>

                                                <select
                                                    id="kondisi-{{ $perkembangan->id_jadwal }}"
                                                    name="kondisi"
                                                    required>

                                                    <option value="" disabled
                                                        {{ !in_array($perkembangan->kondisi, ['Baik', 'Cukup Baik', 'Perlu Perhatian', 'Kurang Baik', 'Siap Panen']) ? 'selected' : '' }}>
                                                        Pilih Kondisi Tanaman
                                                    </option>

                                                    <option value="Baik"
                                                        {{ $perkembangan->kondisi == 'Baik' ? 'selected' : '' }}>
                                                        Baik
                                                    </option>

                                                    <option value="Cukup Baik"
                                                        {{ $perkembangan->kondisi == 'Cukup Baik' ? 'selected' : '' }}>
                                                        Cukup Baik
                                                    </option>

                                                    <option value="Perlu Perhatian"
                                                        {{ $perkembangan->kondisi == 'Perlu Perhatian' ? 'selected' : '' }}>
                                                        Perlu Perhatian
                                                    </option>

                                                    <option value="Kurang Baik"
                                                        {{ $perkembangan->kondisi == 'Kurang Baik' ? 'selected' : '' }}>
                                                        Kurang Baik
                                                    </option>

                                                    <option value="Siap Panen"
                                                        {{ $perkembangan->kondisi == 'Siap Panen' ? 'selected' : '' }}>
                                                        Siap Panen
                                                    </option>

                                                </select>

                                            </div>

                                            <!-- CATATAN ADMIN -->
                                            <div class="detail-item">

                                                <label for="keterangan-{{ $perkembangan->id_jadwal }}">
                                                    Catatan Perawatan
                                                </label>

                                                <textarea
                                                    id="keterangan-{{ $perkembangan->id_jadwal }}"
                                                    name="keterangan"
                                                    rows="2"
                                                    placeholder="Berikan catatan atau saran perawatan...">{{ $perkembangan->keterangan }}</textarea>

                                            </div>

                                            <div class="save-wrapper">

                                                <button type="submit" class="btn-save">
                                                    Simpan
                                                </button>

                                            </div>

                                        </div>

                                    </form>

                                </td>

                            </tr>

                            @empty

                            <tr>
                                <td colspan="3" class="empty-growth">
                                    Belum ada data perkembangan tanaman.
                                </td>
                            </tr>

                            @endforelse

                        </tbody>

                    </table>

                </div>

            </div>

            @endforeach

        </div>

        @else
        @endif

    </div>

    <!-- JAVASCRIPT PEMILIHAN TANAMAN -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {

            const selector = document.getElementById('plantSelector');
            const selectionMessage = document.getElementById('selectionMessage');
            const plantCards = document.querySelectorAll('.plant-card');

            if (!selector) {
                return;
            }

            selector.addEventListener('change', function() {

                const selectedPlantId = this.value;

                document.querySelectorAll('.week-detail').forEach(row => {
                    row.classList.remove('show');
                });

                document.querySelectorAll('.week-toggle').forEach(button => {
                    button.classList.remove('active');
                });
                plantCards.forEach(card => {
                    card.hidden = true;
                });

                if (selectedPlantId === '') {

                    selectionMessage.style.display = 'block';

                    selectionMessage.innerHTML =
                        '🌱 Silakan pilih tanaman yang ingin kamu lihat terlebih dahulu.';

                    return;
                }

                const selectedCard = document.querySelector(
                    '.plant-card[data-plant-id="' + selectedPlantId + '"]'
                );

                if (selectedCard) {

                    selectedCard.hidden = false;
                    selectionMessage.style.display = 'none';

                } else {

                    selectionMessage.style.display = 'block';

                    selectionMessage.innerHTML =
                        'Tanaman yang dipilih tidak ditemukan.';
                }

            });

        });

        // JAVASCRIPT DETAIL MINGGU
        function toggleWeek(id, button) {

            const detail = document.getElementById(id);

            if (!detail) return;

            const isOpen = detail.classList.contains('show');

            document.querySelectorAll('.week-detail').forEach(row => {
                row.classList.remove('show');
            });

            document.querySelectorAll('.week-toggle').forEach(btn => {
                btn.classList.remove('active');
            });

            if (!isOpen) {
                detail.classList.add('show');
                button.classList.add('active');
            }
        }
    </script>

</body>

</html>