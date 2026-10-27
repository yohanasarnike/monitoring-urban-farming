<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar Akun - Sistem Urban Farming</title>

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


        /* REGISTER PAGE */
        .register-page {
            position: relative;
            width: 100%;
            height: 100vh;
            height: 100dvh;
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

        /* BRAND */
        .register-brand {
            position: absolute;
            top: 25px;
            left: 7%;
            z-index: 2;

            font-family: 'Fraunces', Georgia, serif;
            font-size: 24px;
            font-weight: 800;
            color: #fff3ea;
        }

        /* INTRODUCTION */
        .register-intro {
            flex: 1;
            max-width: 520px;
        }

        .register-intro h1 {
            max-width: 600px;
            margin-bottom: 20px;

            font-family: 'Nunito', 'Segoe UI', Arial, sans-serif;
            font-size: clamp(42px, 4.5vw, 68px);
            line-height: 1.1;
            font-weight: 800;
            color: #fff3ea;
            opacity: 0.9;
        }

        .register-intro p {
            max-width: 500px;

            font-family: 'Nunito', 'Segoe UI', Arial, sans-serif;
            font-size: 21px;
            line-height: 1.6;
            color: #cad1c8;
        }

        /* REGISTER CARD */
        .register-card {
            width: 385px;
            max-width: 100%;
            padding: 36px 24px;
            margin-right: 2%;
            transform: translateX(-25px);

            background: rgba(255, 242, 233, 0.88);
            color: #40372c;

            border: 1px solid rgba(255, 255, 255, 0.55);
            border-radius: 24px;
            box-shadow: 0 15px 40px rgba(0, 0, 0, 0.12);
        }

        .register-heading {
            margin-bottom: 20px;
            text-align: center;
            font-family: 'Nunito', 'Segoe UI', Arial, sans-serif;
            font-size: 24px;
            font-weight: 800;
            color: #40372c;
        }

        /* ERROR MESSAGE */
        .register-error {
            padding: 12px;
            margin-bottom: 16px;
            border-radius: 10px;
            background: #ffe3e0;
            color: #a42323;
            font-size: 13px;
        }

        .register-success {
            padding: 12px;
            margin-bottom: 16px;
            border-radius: 10px;
            background: #dff5e6;
            color: #236b43;
            font-size: 13px;
        }

        /* FORM */
        .register-group {
            margin-bottom: 15px;
        }

        .register-group label {
            display: block;
            margin-bottom: 6px;
            padding-left: 2px;
            font-size: 12px;
            font-weight: 700;
            color: #51483c;
        }

        .register-input {
            display: block;
            width: 100%;
            min-height: 40px;
            padding: 8px 12px;
            background: #fff;
            border: 1px solid transparent;
            border-radius: 9px;
            outline: none;

            font-family: 'Nunito', 'Segoe UI', Arial, sans-serif;
            font-size: 13px;
            color: #40372c;

            transition: border-color 0.2s, box-shadow 0.2s;
        }

        .register-input:focus {
            border-color: #8bc7a6;
            box-shadow: 0 0 0 3px rgba(139, 199, 166, 0.22);
        }

        .register-input::placeholder {
            color: #9a8f86;
        }

        /* BUTTON */
        .register-button {
            display: block;
            width: 100%;
            min-height: 40px;
            padding: 9px;
            border: 1px solid #75b59a;
            border-radius: 9px;
            background: #397f66;
            color: #fff;
            font-family: 'Nunito', 'Segoe UI', Arial, sans-serif;
            font-size: 13px;
            font-weight: 800;
            cursor: pointer;

            transition: background 0.2s;
        }

        .register-button:hover {
            background: #438c16;
        }


        .divider {
            display: flex;
            align-items: center;
            gap: 12px;
            margin: 14px 0;
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
            min-height: 40px;
            padding: 9px;
            border: none;
            border-radius: 9px;
            background: #fff;
            color: #51483c;
            font-family: inherit;
            font-size: 12px;
            font-weight: 700;
            text-decoration: none;
        }

        .btn-google:hover {
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
        }

        .btn-google svg {
            width: 20px;
            height: 20px;
        }


        /* LOGIN LINK */
        .register-footer {
            margin-top: 20px;
            text-align: center;

            font-size: 11px;
            font-weight: 700;
            color: #51483c;
        }

        .register-card>a {
            display: block;
            margin-top: 6px;
            text-align: center;

            font-size: 12px;
            font-weight: 700;
            color: #5a9f31;
            text-decoration: none;
        }

        .register-card>a:hover {
            text-decoration: underline;
        }

        /* deskop */
        @media (max-width: 1024px) {
            .register-page {
                padding: 60px 2rem;
                gap: 24px;
            }

            .register-brand {
                left: 2rem;
            }

            .register-intro h1 {
                font-size: 3rem;
            }

            .register-card {
                width: 420px;
                max-width: 100%;
                padding: 38px 24px;
                transform: none;
                margin-right: 0;
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
    <main class="register-page">
        <div class="register-brand">UrbanFarming
        </div>

        <section class="register-intro">
            <h1>Selamat Datang</h1>

            <p>
                Ayo mulai perjalanan
                menanam yang lebih mudah dan teratur
            </p>
        </section>

        <section class="register-card">
            <h2 class="register-heading">
                Buat Akunmuu
            </h2>
            <!-- pesan error validasi -->
            @if ($errors->any())
            <div class="register-error">
                @foreach ($errors->all() as $error)
                <div>{{ $error }}</div>
                @endforeach
            </div>
            @endif

            {{-- Pesan berhasil --}}
            @if (session('success'))
            <div class="register-success">
                {{ session('success') }}
            </div>
            @endif

            <!-- form register -->
            <form action="{{ route('register.submit') }}" method="POST">
                @csrf

                <div class="register-group">
                    <label for="nama">Nama lengkap</label>

                    <input
                        class="register-input"
                        type="text"
                        id="nama"
                        name="nama"
                        value="{{ old('nama') }}"
                        placeholder="Masukkan nama kamu"
                        autocomplete="name"
                        required>
                </div>

                <div class="register-group">
                    <label for="email">Alamat email</label>

                    <input
                        class="register-input"
                        type="email"
                        id="email"
                        name="email"
                        value="{{ old('email') }}"
                        placeholder="Masukkan email kamu"
                        autocomplete="email"
                        required>
                </div>

                <div class="register-group">
                    <label for="password">Password</label>

                    <input
                        class="register-input"
                        type="password"
                        id="password"
                        name="password"
                        placeholder="Buat password"
                        autocomplete="new-password"
                        required>
                </div>

                <button type="submit" class="register-button">
                    Daftar
                </button>

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
            </form>

            <div class="register-footer">
                Sudah punya akun?
                <a href="{{ route('login') }}">Login &gt;</a>
            </div>
        </section>
    </main>

</body>

</html>