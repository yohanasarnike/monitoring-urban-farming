<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Sistem Monitoring Urban Farming</title>


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
            margin: 0;
            overflow: hidden;
        }

        body {
            font-family: 'Nunito', 'Segoe UI', Arial, sans-serif;
            color: #fff3ea;
        }



        .login-page {
            position: relative;
            width: 100%;
            height: 100vh;
            height: 100dvh;
            min-height: 0;

            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 40px;

            padding: 60px 5%;
            overflow: hidden;

            background: linear-gradient(90deg,
                rgba(16, 43, 35, 0.75) 0%,
                rgba(16, 43, 35, 0.35) 60%,
                rgba(16, 43, 35, 0.15) 100%),
            url('{{ asset("img/login.jpeg") }}');
            background-size: cover;
            background-position: center;
            background-repeat: no-repeat;
        }


        .brand {
            position: absolute;
            top: 25px;
            left: 7%;
            z-index: 2;

            font-family: 'Fraunces', Georgia, serif;
            font-size: 24px;
            font-weight: 800;
            color: #fff3ea;
        }

        .intro {
            flex: 1;
            max-width: 520px;
            padding: 0;
        }

        .intro-title {
            max-width: 600px;
            margin-bottom: 20px;

            font-size: clamp(48px, 4.5vw, 68px);
            line-height: 1.1;
            font-weight: 800;
            color: #fff3ea;
            opacity: 0.90;
        }

        .intro-description {
            max-width: 500px;

            font-size: 21px;
            line-height: 1.6;
            color: #cad1c8;
        }


        .login-form {
            width: 390px;
            max-width: 100%;
            padding: 38px 28px;
            margin-right: 2%;
            transform: translateX(-25px);
            background: rgba(255, 242, 233, 0.88);
            color: #40372c;

            border: 1px solid rgba(255, 255, 255, 0.55);
            border-radius: 24px;

            box-shadow: 0 15px 40px rgba(0, 0, 0, 0.12);
        }

        .login-title {
            margin-bottom: 28px;

            text-align: center;
            font-size: 27px;
            font-weight: 800;
            color: #40372c;
        }

        .error-message {
            padding: 12px;
            margin-bottom: 16px;

            border-radius: 10px;
            background: #ffe3e0;
            color: #a42323;
            font-size: 13px;
        }

        .form-group {
            margin-bottom: 18px;
        }

        .form-group label {
            display: block;
            margin-bottom: 8px;
            padding-left: 2px;

            font-size: 12px;
            font-weight: 700;
            color: #51483c;
        }

        .input-box {
            display: flex;
            align-items: center;
            gap: 10px;

            width: 100%;
            min-height: 44px;
            padding: 8px 11px;

            background: #fff;
            border: 1px solid transparent;
            border-radius: 9px;

            transition: border-color 0.2s, box-shadow 0.2s;
        }

        .input-box:focus-within {
            border-color: #8bc7a6;
            box-shadow: 0 0 0 3px rgba(139, 199, 166, 0.22);
        }

        .input-icon {
            display: flex;
            align-items: center;
            justify-content: center;
            flex-shrink: 0;

            width: 24px;
            height: 24px;
            color: #766853;
        }

        .input-icon svg,
        .toggle-password svg {
            width: 18px;
            height: 18px;
        }

        .input-box input {
            flex: 1;
            width: 100%;
            min-width: 0;
            padding: 4px 0;

            border: none;
            outline: none;
            background: transparent;

            font-family: inherit;
            font-size: 13px;
            color: #40372c;
        }

        .input-box input::placeholder {
            color: #9a8f86;
        }

        .toggle-password {
            display: flex;
            align-items: center;
            justify-content: center;
            flex-shrink: 0;

            padding: 4px;
            border: none;
            background: transparent;
            color: #285d48;
            cursor: pointer;
        }

        .forgot-link {
            display: block;
            margin-top: -7px;
            margin-bottom: 22px;

            text-align: right;
            font-size: 11px;
            font-weight: 700;
            color: #51483c;
            text-decoration: none;
        }

        .forgot-link:hover {
            text-decoration: underline;
        }

        .btn-login {
            display: block;
            width: 100%;
            min-height: 44px;
            padding: 11px;

            border: 1px solid #75b59a;
            border-radius: 9px;

            background: #397f66;
            color: #fff;
            font-family: inherit;
            font-size: 13px;
            font-weight: 800;
            cursor: pointer;

            transition: background 0.2s;
        }

        .btn-login:hover {
            background: #438c16;
        }

        .divider {
            display: flex;
            align-items: center;
            gap: 12px;
            margin: 20px 0;
            color: #766853;
            font-size: 12px;
        }

        .divider::before,
        .divider::after {
            content: '';
            flex: 1;
            height: 1px;
            background: #c7bbae;
        }

        .btn-google {
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 9px;
            width: 100%;
            min-height: 44px;
            padding: 10px;
            border: none;
            border-radius: 9px;
            background: #fff;
            color: #51483c;
            font-family: inherit;
            font-size: 12px;
            font-weight: 700;
            text-decoration: none;

            transition: background 0.2s;
        }

        .btn-google:hover {
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
        }

        .btn-google svg {
            width: 20px;
            height: 20px;
        }

        .register-text {
            margin-top: 20px;

            text-align: center;
            font-size: 11px;
            font-weight: 700;
            color: #51483c;
        }

        .register-link {
            color: #5a9f31;
            text-decoration: none;
        }

        .register-link:hover {
            text-decoration: underline;
        }

        /* responsive deskop */
        @media (max-width: 1024px) {
            .login-page {
                padding: 0 2rem;
            }

            .brand {
                left: 2rem;
            }

            .intro {
                margin-left: 0;
            }

            .intro-title {
                font-size: 3rem;
            }
        }

        /* responsive hp */
        /* html,
        body {
            width: 100%;
            height: 100%;
            margin: 0;
            overflow: hidden;
        } */
    </style>
</head>

<body>

    <!-- Container Start -->
    <main class="login-page">
        <div class="brand">UrbanFarming</div>

        <div class="intro">
            <h1 class="intro-title">Selamat Datang </h1>
            <p class="intro-description">Mulai perjalanan menanam yang lebih mudah, teratur, dan berkelanjutan</p>
        </div>

        <div class="login-form">
            <h2 class="login-title">Masuk ke Akunmu</h2>


            <!-- pesan ketikan validasi berhasil -->
            @if (session('success'))
            <div class="success-message">
                {{ session('success') }}
            </div>
            @endif


            <!-- pesan erro akan tampil ketika validasinya error -->
            @if ($errors->any())
            <div class="error-message">
                @foreach ($errors->all() as $error)
                <div> {{ $error }}</div>
                @endforeach
            </div>
            @endif

            <!-- form akan dikirimkan ke route 'login' menggunakan methode post -->
            <form action="{{ route('login.process') }}" method="POST">
                @csrf

                <!-- input email start -->
                <div class="form-group">
                    <label for="email">Alamat email</label>
                    <div class="input-box">
                        <input
                            type="email"
                            id="email"
                            name="email"
                            value="{{ old('email') }}"
                            placeholder="Masukkan email kamu"
                            autocomplete="email"
                            required>
                    </div>
                </div>
                <!-- Input email end -->

                <!-- input password start -->
                <div class="form-group">
                    <label for="password">Password</label>
                    <div class="input-box">
                        <input
                            type="password"
                            id="password"
                            name="password"
                            placeholder="Masukkan password kamu"
                            autocomplete="current-password"
                            required>

                        <button
                            type="button"
                            class="toggle-password"
                            onclick="togglePassword()"
                            aria-label="Tampilkan password">

                            <!-- Ketika Mata tertutup untuk kondisi awalnya -->
                            <svg id="eyeClosed"
                                viewBox="0 0 24 24"
                                fill="none"
                                stroke="currentColor"
                                stroke-width="1.8"
                                stroke-linecap="round"
                                stroke-linejoin="round">
                                <path d="M3 3l18 18"></path>
                                <path d="M10.6 10.6a2 2 0 0 0 2.8 2.8"></path>
                                <path d="M9.9 5.2A10.8 10.8 0 0 1 12 5c5 0 9 7 9 7a15.5 15.5 0 0 1-4 4.8"></path>
                                <path d="M6.6 6.6C4.1 8.2 3 12 3 12s4 7 9 7a10 10 0 0 0 4-.8"></path>
                            </svg>

                            <!-- Mata terbuka: ketika password terlihat -->
                            <svg id="eyeOpen"
                                viewBox="0 0 24 24"
                                fill="none"
                                stroke="currentColor"
                                stroke-width="1.8"
                                stroke-linecap="round"
                                stroke-linejoin="round"
                                style="display: none;">
                                <path d="M2 12s4-7 10-7 10 7 10 7-4 7-10 7-10-7-10-7z"></path>
                                <circle cx="12" cy="12" r="3"></circle>
                            </svg>
                        </button>
                    </div>
                </div>
                <!-- input password End -->

                <!-- lupa password start -->
                <a href="#" class="forgot-link">Lupa password?</a>

                <!-- buttono login -->
                <button type="submit" class="btn-login">Login</button>
            </form>

            <!-- pembatas -->
            <div class="divider">atau</div>

            <!-- Tombol goggle -->
            <a href="#" class="btn-google">
                <!-- Logo Google -->
                <svg viewBox="0 0 48 48">
                    <path fill="#EA4335" d="M24 9.5c3.5 0 6.6 1.2 9.1 3.6l6.8-6.8C35.8 2.4 30.3 0 24 0 14.6 0 6.5 5.4 2.6 13.3l7.9 6.1C12.4 13.6 17.7 9.5 24 9.5z"></path>
                    <path fill="#4285F4" d="M46.5 24.5c0-1.6-.1-3.1-.4-4.5H24v9h12.7c-.6 3-2.3 5.5-4.8 7.2l7.5 5.8c4.4-4.1 7.1-10.1 7.1-17.5z"></path>
                    <path fill="#FBBC05" d="M10.5 28.6A14.5 14.5 0 0 1 9.5 24c0-1.6.3-3.1.8-4.6l-7.9-6.1A24 24 0 0 0 0 24c0 3.9.9 7.5 2.6 10.7l7.9-6.1z"></path>
                    <path fill="#34A853" d="M24 48c6.5 0 11.9-2.1 15.9-5.8l-7.5-5.8c-2.1 1.4-4.8 2.3-8.4 2.3-6.3 0-11.6-4.1-13.5-9.9l-7.9 6.1C6.5 42.6 14.6 48 24 48z"></path>
                </svg>
                Lanjutkan dengan Google
            </a>
            <!-- lupa password end -->

            <!-- Link ke halaman registrasinya -->
            <div class="register-text">
                Belum punya akun?
                <a href="{{ route('register.submit') }}" class="register-link">Daftar &gt
                </a>
            </div>
        </div>
    </main>


    <script>
        function togglePassword() {
            const input = document.getElementById('password');
            const eyeOpen = document.getElementById('eyeOpen');
            const eyeClosed = document.getElementById('eyeClosed');

            if (input.type === 'password') {
                input.type = 'text';
                eyeOpen.style.display = 'block';
                eyeClosed.style.display = 'none';
            } else {
                input.type = 'password';
                eyeOpen.style.display = 'none';
                eyeClosed.style.display = 'block';
            }
        }
    </script>
</body>

</html>