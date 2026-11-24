<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Reset Password - UrbanFarming</title>

    <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700;800;900&family=Fraunces:wght@600;700&display=swap" rel="stylesheet">

    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Nunito', sans-serif;
            min-height: 100vh;
        }

        .reset-page {
            min-height: 100vh;
            display: flex;
            align-items: center;
            padding: 40px 5%;
            background: linear-gradient(rgba(8, 35, 27, .65), rgba(8, 35, 27, .65)),
            url("{{ asset('img/login.jpeg') }}");
            background-size: cover;
            background-position: center;
        }

        .brand {
            position: absolute;
            top: 32px;
            left: 7%;
            color: white;
            font-family: 'Fraunces', serif;
            font-size: 34px;
            font-weight: 700;
        }

        .welcome-text {
            width: 48%;
            color: #fff3e8;
        }

        .welcome-text h1 {
            font-size: clamp(42px, 5vw, 80px);
            font-weight: 900;
        }

        .reset-card {
            width: 52%;
            max-width: 800px;
            padding: 55px;
            margin-left: auto;
            border-radius: 30px;
            background: rgba(255, 244, 232, .93);
            backdrop-filter: blur(10px);
            box-shadow: 0 15px 40px rgba(0, 0, 0, .2);
        }

        .reset-card h2 {
            text-align: center;
            color: #302d27;
            font-size: 42px;
            font-weight: 900;
            margin-bottom: 18px;
        }

        .description {
            text-align: center;
            color: #68645f;
            font-size: 18px;
            line-height: 1.6;
            margin-bottom: 30px;
        }

        .form-group {
            margin-bottom: 20px;
        }

        .form-group label {
            display: block;
            margin-bottom: 8px;
            color: #302d27;
            font-weight: 800;
        }

        .form-group input {
            width: 100%;
            height: 60px;
            padding: 0 18px;
            border: 1px solid #ddd;
            border-radius: 13px;
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
            height: 60px;
            border: none;
            border-radius: 13px;
            background: #397f66;
            color: white;
            font-size: 19px;
            font-weight: 900;
            font-family: inherit;
            cursor: pointer;
            transition: .3s;
        }

        .btn-reset:hover {
            background: #438c16;
        }

        .error-message {
            color: #c0392b;
            font-size: 14px;
            margin-bottom: 15px;
        }

        .back-login {
            display: block;
            text-align: center;
            color: #397f66;
            text-decoration: none;
            font-size: 17px;
            font-weight: 900;
            margin-top: 25px;
        }

        @media(max-width: 900px) {
            .reset-page {
                justify-content: center;
                padding: 100px 25px 30px;
            }

            .brand {
                top: 25px;
                left: 30px;
                font-size: 28px;
            }

            .welcome-text {
                display: none;
            }

            .reset-card {
                width: 100%;
                max-width: 600px;
                padding: 40px 30px;
            }
        }

        @media(max-width: 480px) {
            .reset-card {
                padding: 35px 22px;
            }

            .reset-card h2 {
                font-size: 30px;
            }

            .description {
                font-size: 15px;
            }
        }
    </style>
</head>

<body>

    <div class="reset-page">

        <div class="brand">UrbanFarming</div>

        <div class="welcome-text">
            <h1>Selamat Datang</h1>
        </div>

        <div class="reset-card">

            <h2>Buat Password Baru</h2>

            <p class="description">
                Silakan masukkan password baru untuk akun UrbanFarming kamu.
            </p>

            @if($errors->any())
            <div class="error-message">
                {{ $errors->first() }}
            </div>
            @endif

            <form action="{{ route('password.update') }}" method="POST">
                @csrf

                <input type="hidden" name="token" value="{{ $token }}">
                <input type="hidden" name="email" value="{{ $email }}">

                <div class="form-group">
                    <label>Password Baru</label>
                    <input
                        type="password"
                        name="password"
                        placeholder="Masukkan password baru"
                        required
                        minlength="8">
                </div>

                <div class="form-group">
                    <label>Konfirmasi Password</label>
                    <input
                        type="password"
                        name="password_confirmation"
                        placeholder="Masukkan ulang password baru"
                        required
                        minlength="8">
                </div>

                <button type="submit" class="btn-reset">
                    Simpan Password Baru
                </button>
            </form>

            <a href="{{ route('login') }}" class="back-login">
                ← Kembali ke Login
            </a>

        </div>

    </div>

</body>

</html>