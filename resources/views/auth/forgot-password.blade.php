<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Lupa Password - UrbanFarming</title>

    <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700;800;900&family=Fraunces:wght@600;700&display=swap" rel="stylesheet">

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
            font-family: 'Nunito', sans-serif;
        }

        .forgot-page {
            width: 100%;
            height: 100dvh;
            min-height: 0;
            display: flex;
            align-items: center;
            padding: 30px 6%;
            overflow: hidden;

            background: linear-gradient(rgba(8, 35, 27, .65), rgba(8, 35, 27, .65)),
            url("{{ asset('img/login.jpeg') }}");

            background-size: cover;
            background-position: center;
        }

        .brand {
            position: absolute;
            top: 35px;
            left: 7%;
            color: white;
            font-family: 'Fraunces', serif;
            font-size: 30px;
            font-weight: 700;
        }

        .welcome-text {
            width: 48%;
            color: #fff3e8;
        }

        .welcome-text h1 {
            font-size: clamp(60px, 6vw, 95px);
            font-weight: 900;
            line-height: 1.05;
            letter-spacing: -2px;
        }

        .forgot-card {
            width: 48%;
            max-width: 650px;
            padding: 40px 45px;
            margin-left: auto;
            border-radius: 25px;

            background: rgba(255, 244, 232, .93);
            backdrop-filter: blur(10px);
            box-shadow: 0 15px 40px rgba(0, 0, 0, .2);
        }

        .forgot-card h2 {
            text-align: center;
            color: #302d27;
            font-size: clamp(27px, 3vw, 38px);
            font-weight: 900;
            margin-bottom: 12px;
        }

        .description {
            text-align: center;
            color: #68645f;
            font-size: 16px;
            line-height: 1.6;
            margin-bottom: 25px;
        }

        .form-group {
            margin-bottom: 18px;
        }

        .form-group input {
            width: 100%;
            height: 55px;
            padding: 0 18px;
            border: 1px solid #ddd;
            border-radius: 12px;
            background: white;
            font-size: 16px;
            font-family: inherit;
            outline: none;
        }

        .form-group input:focus {
            border-color: #397f66;
            box-shadow: 0 0 0 3px rgba(57, 127, 102, .12);
        }

        .btn-reset {
            width: 100%;
            height: 55px;
            border: none;
            border-radius: 12px;
            background: #397f66;
            color: white;
            font-size: 17px;
            font-weight: 900;
            font-family: inherit;
            cursor: pointer;
            transition: .3s;
        }

        .btn-reset:hover {
            background: #438c16;
        }

        .back-login {
            display: block;
            text-align: center;
            color: #397f66;
            text-decoration: none;
            font-size: 16px;
            font-weight: 900;
            margin-top: 22px;
        }

        .back-login:hover {
            color: #438c16;
        }

        .error-message {
            color: #c0392b;
            font-size: 14px;
            margin-top: 8px;
        }

        .success-message {
            color: #267a48;
            text-align: center;
            margin-bottom: 15px;
        }

        /* deskop */
        @media(max-width: 1024px) {
            .forgot-page {
                padding: 0 2rem;
            }

            .brand {
                left: 2rem;
            }

            .welcome-text {
                width: 45%;
            }

            .welcome-text h1 {
                font-size: clamp(48px, 6vw, 69px);
                line-height: 1.05;
            }

            .forgot-card {
                width: 52%;
                padding: 35px 30px;
            }

            .forgot-card h2 {
                font-size: 32px;
            }

            .description {
                font-size: 15px;
            }
        }
    </style>
</head>

<body>

    <div class="forgot-page">

        <div class="brand">UrbanFarming</div>

        <div class="welcome-text">
            <h1>Selamat<br>
                Datang</h1>
        </div>

        <div class="forgot-card">

            <h2>Lupa Password?</h2>

            <p class="description">
                Masukkan alamat email Anda. Kami akan mengirimkan
                tautan untuk mengatur ulang password.
            </p>

            @if(session('status'))
            <div class="success-message">
                {{ session('status') }}
            </div>
            @endif

            @if($errors->any())
            <div class="error-message">
                {{ $errors->first() }}
            </div>
            @endif

            <form action="{{ route('password.email') }}" method="POST">
                @csrf

                <div class="form-group">
                    <input
                        type="email"
                        name="email"
                        placeholder="Email Anda"
                        value="{{ old('email') }}"
                        required>
                </div>

                <button type="submit" class="btn-reset">
                    Kirim Link Reset
                </button>
            </form>

            <a href="{{ route('login') }}" class="back-login">
                ← Kembali ke Login
            </a>

        </div>

    </div>

</body>

</html>