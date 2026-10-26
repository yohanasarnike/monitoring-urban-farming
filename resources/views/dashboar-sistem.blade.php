<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Sistem Monitoring Urban Farming</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap"
        rel="stylesheet">

    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        html,
        body {
            width: 100%;
            height: 100%;
            overflow: hidden;
        }

        body {
            font-family: 'Poppins', sans-serif;
            color: #fff3ea;
        }

        /* Background dan halaman utama */
        body {
            background: linear-gradient(90deg,
                rgba(16, 43, 35, 0.82) 0%,
                rgba(16, 43, 35, 0.58) 48%,
                rgba(16, 43, 35, 0.12) 100%),
            url("{{ asset('img/dash.png') }}");

            background-size: cover;
            background-position: center;
            background-repeat: no-repeat;
            background-attachment: fixed;
        }

        /* Navbar */
        .navbar {
            height: 80px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 0 5%;

            background: #266210;
            border-bottom: 1px solid rgba(255, 255, 255, 0.12);
        }

        .logo {
            font-size: 1.5rem;
            font-weight: 700;
            color: #ffffff;
            letter-spacing: -0.5px;
        }

        .nav-menu {
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .nav-menu a {
            display: inline-flex;
            align-items: center;
            justify-content: center;

            padding: 12px 24px;
            border-radius: 12px;

            color: #ffffff;
            text-decoration: none;
            font-size: 1.1rem;
            font-weight: 700;

            background: transparent;
            transition: background 0.25s ease;
        }

        .nav-menu a.active,
        .nav-menu a:hover {
            background: rgba(255, 255, 255, 0.18);
        }


        .nav-menu .btn-register {
            background: transparent;
        }

        .nav-menu .btn-register.active,
        .nav-menu .btn-register:hover {
            background: rgba(255, 255, 255, 0.18);
        }

        /* Hero Section */
        .hero {
            height: calc(100vh - 50px);
            height: calc(100dvh - 50px);
            display: flex;
            justify-content: flex-start;
            align-items: center;
            text-align: left;
            padding: 60px 6%;
            overflow: hidden;
        }

        .hero-content {
            width: 100%;
            max-width: 850px;
        }

        .tagline {
            display: block;
            margin-bottom: 14px;

            color: #fff3ea;
            font-size: 2rem;
            font-weight: 400;
            line-height: 1.5;
        }

        .hero h1 {
            max-width: 850px;
            margin-bottom: 24px;

            color: #fff3ea;
            font-size: 3.8rem;
            font-weight: 800;
            line-height: 1.12;
            letter-spacing: -1.5px;
        }

        .description {
            max-width: 650px;
            margin-bottom: 30px;

            color: #e3e8df;
            font-size: 1.25rem;
            font-weight: 400;
            line-height: 1.8;
        }


        /* Responsif untuk Desktop */
        /* Responsif untuk Desktop */
        @media (min-width: 1024px) {
            .navbar {
                height: 60px;
                padding: 0 5%;
                flex-wrap: nowrap;
                gap: 20px;
            }

            .logo {
                font-size: 1.5rem;
            }

            .nav-menu {
                gap: 8px;
            }

            .nav-menu a {
                font-size: 1.1rem;
            }

            .hero {
                height: calc(100vh - 50px);
                height: calc(100dvh - 50px);
                min-height: 0;
                padding: 60px 5%;
                align-items: center;
                justify-content: flex-start;
            }

            .hero-content {
                max-width: 750px;
                width: 100%;
            }

            .tagline {
                font-size: 2rem;
            }

            .hero h1 {
                max-width: 700px;
                font-size: 3.8rem;
                line-height: 1.1;
            }

            .description {
                max-width: 650px;
                font-size: 1.25rem;
                margin-left: 0;
                margin-right: 0;
            }
        }
    </style>
</head>

<body>
    <!-- Navbar Start -->
    <header class="navbar">
        <div class="logo">
            Monitoring Urban Farming
        </div>

        <!-- Pembungkus tautan menu navigasi -->
        <!-- Pembungkus tautan menu navigasi -->
        <nav class="nav-menu">
            <a href="{{ route('login') }}"
                class="{{ request()->routeIs('login') ? 'active' : '' }}">
                Login
            </a>

            <a href="{{ route('register') }}"
                class="btn-register {{ request()->routeIs('register') ? 'active' : '' }}">
                Daftar
            </a>
        </nav>
    </header>
    <!-- Navbar end -->

    <!-- Hero Section Start -->
    <section class="hero">
        <div class="hero-content">

            <span class="tagline">
                Selamat Datang di Sistem
            </span>

            <h1>Monitoring Urban Farming</h1>

            <p class="description">
                Pantau dan kelola pertumbuhan tanaman kamu,
                dengan lebih mudah dan efisien😊
            </p>
        </div>
    </section>
    <!-- Hero Section End -->

</body>

</html>