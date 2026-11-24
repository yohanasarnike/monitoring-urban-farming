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
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&family=EB+Garamond:wght@700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet"
        href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <link rel="stylesheet" href="{{ asset('css/dashboardUtama.css') }}">

    <style>
        body {
            background-image: url('/img/bg.png');
            background-size: cover;
            background-position: center;
            background-repeat: no-repeat;
            background-attachment: fixed;
        }

        /* DASHBOARD ADMIN */
        .admin-dashboard .features-grid {
            display: flex;
            justify-content: flex-start;
            align-items: flex-start;
            margin-top: 35px;
            margin-bottom: 40px;
        }

        /* Card Monitoring */
        .admin-dashboard .feature-card {
            width: 300px;
            min-height: 190px;
            padding: 24px;
            box-sizing: border-box;

            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;

            text-decoration: none;
        }

        .admin-dashboard .feature-icon {
            width: 48px;
            height: 48px;
            font-size: 20px;
            margin-bottom: 12px;
        }

        .admin-dashboard .feature-card h3 {
            font-size: 16px;
            margin-bottom: 8px;
        }

        .admin-dashboard .feature-card p {
            font-size: 12px;
            line-height: 1.6;
        }

        /* NAVBAR ADMIN */
        .navbar {
            display: flex;
            align-items: center;
            justify-content: space-between;
        }

        .navbar .nav-links {
            display: flex;
            align-items: center;
            gap: 28px;
        }

        .navbar .nav-links a {
            text-decoration: none;
            position: relative;
        }

        /* Notifikasi */
        .nav-notification {
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .nav-notification i {
            font-size: 20px;
        }

        .notification-dot {
            position: absolute;
            top: -4px;
            right: -6px;

            width: 10px;
            height: 10px;

            background-color: #ff4d5a;
            border-radius: 50%;
        }

        /* Profil */
        .profile-wrapper {
            position: relative;
        }

        .nav-profile {
            display: flex;
            align-items: center;
            gap: 8px;
            cursor: pointer;
        }

        .nav-profile i {
            font-size: 20px;
        }

        /* Dropdown Profil */
        .profile-dropdown {
            display: none;
            position: absolute;

            top: 40px;
            right: 0;

            width: 190px;
            padding: 15px;

            background: #ffffff;
            border-radius: 12px;

            box-shadow: 0 5px 20px rgba(0, 0, 0, 0.15);

            z-index: 999;
        }

        .profile-dropdown.show {
            display: block;
        }

        .profile-dropdown .profile-name {
            display: block;
            color: #285f45;
            font-weight: 700;
            margin-bottom: 12px;
            padding-bottom: 10px;
            border-bottom: 1px solid #eeeeee;
        }

        .profile-dropdown form {
            margin: 0;
        }

        .profile-dropdown button {
            width: 100%;
            display: flex;
            align-items: center;
            gap: 10px;

            padding: 9px 5px;

            background: transparent;
            border: none;

            color: #d94343;
            font-family: 'Poppins', sans-serif;
            font-size: 14px;
            font-weight: 600;

            cursor: pointer;
        }

        .profile-dropdown button:hover {
            color: #a82323;
        }

        @media (max-width: 1024px) {

            .navbar {
                padding: 18px 30px;
            }

            .navbar h2 {
                font-size: 28px;
            }

            .navbar .nav-links {
                gap: 20px;
            }

            .main-container {
                width: 90%;
                margin-left: auto;
                margin-right: auto;
            }

            .welcome-banner {
                padding: 30px;
            }

            .welcome-banner h1 {
                font-size: 28px;
            }

            .welcome-banner p {
                font-size: 15px;
            }

            .admin-dashboard .features-grid {
                margin-top: 30px;
            }

            .admin-dashboard .feature-card {
                width: 300px;
                min-height: 190px;
            }
        }
    </style>
</head>

<body>

    <!-- Navbar Web -->
    <div class="navbar">
         <h2 style="">🌱 Selamat Datang, Admin {{ Auth::user()->nama ?? Auth::user()->username }}!</h2>
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
                <h1>Selamat Datang di Dashboard Admin!</h1>
                <p>Pantau pertumbuhan tanaman anggota, kelola jadwal perawatan, dan temukan solusi untuk setiap kendala budidaya.</p>
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

             <a href="{{ route('admin.monitoring') }}"
                class="feature-card">
                <div class="feature-icon">
                    <i class="fa-solid fa-seedling"></i>
                </div>
                <h3>Monitoring</h3>
                <p>Pantau tanaman setiap pengguna</p>
            </a>

             <a href="{{ route('admin.konsultasi.index') }}" class="feature-card">
                <div class="feature-icon">
                    <i class="fa-regular fa-comments"></i>
                </div>
                <h3>Konsultasi</h3>
                <p>Diskusikan kendala pertumbuhan tanaman</p>
            </a>
        </div>
    </div>

  
    <script>
        function toggleProfile() {

            const dropdown = document.getElementById('profileDropdown');

            dropdown.classList.toggle('show');

        }

        // Tutup dropdown jika klik di luar area profil
        document.addEventListener('click', function(event) {

            const profile = document.querySelector('.profile-wrapper');
            const dropdown = document.getElementById('profileDropdown');

            if (profile && !profile.contains(event.target)) {
                dropdown.classList.remove('show');
            }

        });
    </script>


</body>
</html>