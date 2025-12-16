<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - MyKos</title>

    <!-- Bootstrap Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">

    <style>
        * {
            box-sizing: border-box;
            font-family: "Poppins", sans-serif;
        }

        body {
            background: #F8F9FB;
            margin: 0;
            height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
        }

        .login-card {
            background: #ffffff;
            width: 100%;
            max-width: 420px;
            padding: 45px 40px;
            border-radius: 20px;
            text-align: center;
            box-shadow: 0px 7px 15px rgba(0,0,0,0.15);
        }

        .logo {
            margin-bottom: 30px;
        }

        label {
            text-align: left;
            display: block;
            font-weight: 600;
            margin-bottom: 6px;
            font-size: 14px;
            color: #222;
        }

        .form-input {
            width: 100%;
            padding: 13px 16px;
            border-radius: 14px;
            background: #EEEEEE;
            border: 1px solid #E4E4E4;
            font-size: 14px;
            outline: none;
            transition: 0.2s ease;
        }

        .form-input:focus {
            border-color: #3D63A9;
            background: #fff;
            box-shadow: 0 0 4px rgba(61, 99, 169, 0.3);
        }

        .btn-login {
            width: 100%;
            padding: 14px;
            margin-top: 25px;
            border: none;
            border-radius: 14px;
            background: #3D63A9;
            color: white;
            font-weight: 600;
            font-size: 15px;
            cursor: pointer;
            display: flex;
            justify-content: center;
            align-items: center;
            gap: 6px;
            transition: 0.2s ease;
        }

        .btn-login:hover {
            background: #365a98;
        }

        p {
            margin-top: 18px;
            font-size: 14px;
            color: #666;
        }

        p a {
            color: #3D63A9;
            text-decoration: none;
            font-weight: 600;
        }

        p a:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>

    <div class="login-card">
        
        <img src="{{ asset('img/logomykos.png') }}" class="logo" width="110" alt="Logo">

        <form method="POST" action="{{ url('/login') }}">
            @csrf

            <label for="email">Email</label>
            <input class="form-input" type="email" id="email" name="email" placeholder="Masukkan email anda" required>

            <label for="password" style="margin-top: 18px;">Password</label>
            <input class="form-input" type="password" id="password" name="password" placeholder="Masukkan password anda" required>

            <button class="btn-login" type="submit">
                <i class="bi bi-box-arrow-in-right"></i> Login
            </button>
        </form>

        <p>Belum punya akun? <a href="{{ route('register') }}">Daftar Sekarang</a></p>

    </div>

</body>
</html>
