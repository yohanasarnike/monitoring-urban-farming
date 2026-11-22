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
            <a href="" class="active">Beranda</a>
            <a href="" class="notification-badge"><i class="fa-regular fa-bell"></i> Notifikasi</a>
            <a href=""><i class="fa-regular fa-user"></i> Profil</a>
            <form action="{{ route('logout') }}" method="POST" style="display: inline;">
                @csrf
                <!-- <button type="submit" style="background: none; border: none; color: inherit; font: inherit; cursor: pointer; padding: 0 10px;">
                    <i class="fa-solid fa-right-from-bracket"></i> Keluar
                </button> -->
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
            <a href="/kelola-data" class="feature-card">
                <div class="feature-icon">
                    <i class="fa-regular fa-calendar-days"></i>
                </div>
                <h3>Kelola Data Tanaman</h3>
                <p>Kelola data tanaman</p>
            </a>

            <a href="" class="feature-card">
                <div class="feature-icon">
                    <i class="fa-solid fa-seedling"></i>
                </div>
                <h3>Monitoring</h3>
                <p>Pantau tanaman setiap pengguna</p>
            </a>

            <a href="" class="feature-card">
                <div class="feature-icon">
                    <i class="fa-regular fa-comments"></i>
                </div>
                <h3>Konsultasi</h3>
                <p>Diskusikan kendala pertumbuhan tanaman</p>
            </a>
        </div>
    </div>
</body>
</html>