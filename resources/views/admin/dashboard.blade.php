<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Admin - Urban Farming</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&family=EB+Garamond:wght@700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="{{ asset('css/dashboardUtama.css') }}">

    <style>
        body {
            background-image: url('/img/bg.png');
            background-size: cover;
            background-position: center;
            background-repeat: no-repeat;
            background-attachment: fixed;
        }

        .admin-dashboard .features-grid {
            display: flex;
            flex-wrap: wrap;
            gap: 24px;
            justify-content: flex-start;
            align-items: flex-start;
            margin-top: 35px;
            margin-bottom: 40px;
        }

        .admin-dashboard .feature-card {
            position: relative;
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

        .card-badge {
            position: absolute;
            top: 14px;
            right: 14px;
            background: #ef4444;
            color: white;
            font-size: 11px;
            font-weight: 700;
            padding: 3px 9px;
            border-radius: 999px;
        }

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

    <div class="navbar">
        <h2>🌱 Selamat Datang, Admin!</h2>

        <div class="nav-links">
            <a href="{{ route('admin.dashboard') }}" class="active">Beranda</a>

            <a href="{{ route('admin.konsultasi') }}" class="nav-notification">
                <i class="fa-regular fa-bell"></i>
                Notifikasi
                @if(isset($konsultasiBaru) && $konsultasiBaru > 0)
                    <span class="notification-dot"></span>
                @endif
            </a>

            <div class="profile-wrapper">
                <a href="#" class="nav-profile" onclick="event.preventDefault(); toggleProfile();">
                    <i class="fa-regular fa-user"></i>
                    Profil
                </a>

                <div class="profile-dropdown" id="profileDropdown">
                    <span class="profile-name">Administrator</span>
                    <form action="{{ route('logout') }}" method="POST">
                        @csrf
                        <button type="submit">
                            <i class="fa-solid fa-right-from-bracket"></i>
                            Logout
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <div class="main-container admin-dashboard">
        <div class="welcome-banner">
            <div class="welcome-text">
                <h1>Dashboard Admin Urban Farming</h1>
                <p>
                    Pantau perkembangan pertumbuhan tanaman serta kelola konsultasi masuk dari pengguna Urban Farming.
                </p>
            </div>
        </div>

        <div class="features-grid">
            <a href="{{ route('admin.monitoring') }}" class="feature-card">
                <div class="feature-icon">
                    <i class="fa-solid fa-chart-line"></i>
                </div>
                <h3>Monitoring Tanaman</h3>
                <p>
                    Pantau seluruh tanaman pengguna dan lihat perkembangan pertumbuhannya.
                </p>
            </a>

            <a href="{{ route('admin.konsultasi') }}" class="feature-card">
                @if(isset($konsultasiBaru) && $konsultasiBaru > 0)
                    <span class="card-badge">{{ $konsultasiBaru }} Baru</span>
                @endif
                <div class="feature-icon">
                    <i class="fa-regular fa-comments"></i>
                </div>
                <h3>Konsultasi Masuk</h3>
                <p>
                    Terima dan balas pesan konsultasi tanaman dari pengguna secara realtime.
                </p>
            </a>
        </div>
    </div>

    <script>
        function toggleProfile() {
            const dropdown = document.getElementById('profileDropdown');
            dropdown.classList.toggle('show');
        }

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