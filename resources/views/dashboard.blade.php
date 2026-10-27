<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard - Urban Farming Monitoring</title>
    <!-- Google Fonts & FontAwesome untuk Icon -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="{{ asset('css/dashboardUtama.css') }}">
</head>

<body>

    <!-- Navbar Web -->
    <div class="navbar">
        <h2 style="">🌱 Selamat Datang, {{ Auth::user()->nama ?? Auth::user()->username }}!</h2>
        <div class="nav-links">
            <a href="/dashboard" class="active">Beranda</a>
            <a href="/notifikasi" class="notification-badge"><i class="fa-regular fa-bell"></i> Notifikasi</a>
            <a href="/profil"><i class="fa-regular fa-user"></i> Profil</a>
            <form action="{{ route('logout') }}" method="POST" style="display: inline;">
                @csrf
                <button type="submit" style="background: none; border: none; color: inherit; font: inherit; cursor: pointer; padding: 0 10px;">
                    <i class="fa-solid fa-right-from-bracket"></i> Keluar
                </button>
            </form>
        </div>
    </div>

    <div class="main-container">

        <!-- Notifikasi Pesan Sukses dari Form -->
        @if(session('success'))
        <div class="alert-success">
            <i class="fa-solid fa-circle-check"></i> {{ session('success') }}
        </div>
        @endif

        <!-- Banner Selamat Datang -->
        <div class="welcome-banner">
            <div class="welcome-text">
                <h1>Kelola Kebun Urban Anda</h1>
                <p>Pantau perkembangan tanaman, jadwalkan perawatan, dan konsultasikan kendala pertanian Anda dengan mudah.</p>
            </div>
        </div>

        <!-- 3 Fitur Utama (Jadwal, Tambah tanaman, Konsultasi) -->
        <div class="features-grid">
            <a href="/jadwal-perawatan" class="feature-card">
                <div class="feature-icon">
                    <i class="fa-regular fa-calendar-days"></i>
                </div>
                <h3>Jadwal Perawatan</h3>
                <p>Kelola jadwal penyiraman, pemupukan, dan pemantauan harian tanaman.</p>
            </a>

            <a href="/tanaman/tambah" class="feature-card">
                <div class="feature-icon">
                    <i class="fa-solid fa-seedling"></i>
                </div>
                <h3>Tambah Tanaman</h3>
                <p>Tambahkan data tanaman baru, mulai dari jenis tanaman, tanggal tanam, hingga lokasi penanaman.</p>
            </a>

            <a href="/konsultasi" class="feature-card">
                <div class="feature-icon">
                    <i class="fa-regular fa-comments"></i>
                </div>
                <h3>Konsultasi</h3>
                <p>Diskusikan kendala pertumbuhan tanaman Anda dengan ahli pertanian.</p>
            </a>
        </div>


        <!-- Bagian Daftar Tanaman Aktif -->
        <h3 class="section-title">Tanaman Aktif Anda</h3>

        <div class="plant-grid">
            @forelse($tanamanAktif as $tanaman)
            <div class="plant-card">
                <!-- Icon / Ilustrasi Tanaman Sederhana -->
                <div style="background: #e9f5ed; height: 120px; display: flex; align-items: center; justify-content: center; color: #2d6a4f; font-size: 40px;">
                    <i class="fa-solid fa-seedling"></i>
                </div>
                <div class="plant-info">
                    <h4>{{ $tanaman->jenis_bibit }}</h4>
                    <p><strong>Lahan:</strong> {{ $tanaman->jenis_lahan }}</p>
                    <p><strong>Lokasi:</strong> {{ $tanaman->lokasi_tanam }}</p>
                    <p style="margin-top: 5px; font-size: 12px; color: #888;">
                        📅 Tgl Tanam: {{ $tanaman->tanggal_tanam }}
                    </p>
                </div>
            </div>
            @empty
            <div style="grid-column: span 3; background: white; padding: 30px; text-align: center; border-radius: 12px; color: #666;">
                <i class="fa-solid fa-seedling" style="font-size: 36px; color: #ccc; margin-bottom: 10px;"></i>
                <p>Belum ada tanaman aktif. Yuk, mulai input data tanaman pertamamu!</p>
                <br>
                <a href="/tanaman/tambah" class="btn-tambah" style="display: inline-block;">Input Tanaman Sekarang</a>
            </div>
            @endforelse
        </div>

    </div>

</body>

</html>