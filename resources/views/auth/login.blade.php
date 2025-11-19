<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Sistem Kos</title>

    <!-- Bootstrap Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">

    <style>
        * {
            box-sizing: border-box;
            font-family: "Poppins", sans-serif;
        }

        body {
            background-color: #f4f6f9;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
        }

        .login-container {
            background: #fff;
            border-radius: 16px;
            padding: 40px 35px;
            width: 100%;
            max-width: 400px;
            box-shadow: 0 6px 18px rgba(0, 0, 0, 0.08);
            text-align: center;
            transition: all 0.3s ease;
        }

        .login-container:hover {
            box-shadow: 0 8px 24px rgba(0, 0, 0, 0.1);
        }

        h2 {
            color: #222;
            font-weight: 600;
            margin-bottom: 25px;
        }

        label {
            display: block;
            text-align: left;
            font-weight: 500;
            margin-top: 15px;
            color: #444;
        }

        input[type="email"],
        input[type="password"] {
            width: 100%;
            padding: 12px 14px;
            margin-top: 6px;
            border: 1px solid #ddd;
            border-radius: 10px;
            background-color: #fafafa;
            transition: all 0.2s ease;
        }

        input:focus {
            border-color: #0d6efd;
            background-color: #fff;
            box-shadow: 0 0 6px rgba(13, 110, 253, 0.2);
            outline: none;
        }

        button {
            margin-top: 25px;
            width: 100%;
            padding: 12px;
            background: #0d6efd;
            color: white;
            font-weight: 600;
            border: none;
            border-radius: 10px;
            cursor: pointer;
            transition: all 0.3s ease;
        }

        button:hover {
            background: #0b5ed7;
            transform: translateY(-2px);
        }

        .alert {
            background-color: #e7f3ec;
            color: #216c3e;
            border: 1px solid #c3e6cb;
            padding: 10px;
            border-radius: 8px;
            margin-bottom: 15px;
        }

        p {
            margin-top: 20px;
            color: #555;
            font-size: 0.95rem;
        }

        a {
            color: #0d6efd;
            text-decoration: none;
            font-weight: 500;
        }

        a:hover {
            text-decoration: underline;
        }

        .icon {
            font-size: 40px;
            color: #0d6efd;
            margin-bottom: 10px;
        }
    </style>
</head>
<body>
    <div class="login-container">
        <i class="bi bi-door-open icon"></i>
        <h2>Login Sistem Kos</h2>

        @if(session('success'))
            <div class="alert">
                {{ session('success') }}
            </div>
        @endif

        <form method="POST" action="{{ url('/login') }}">
            @csrf
            <label for="email">Email</label>
            <input id="email" type="email" name="email" placeholder="Masukkan email Anda" required>

            <label for="password">Password</label>
            <input id="password" type="password" name="password" placeholder="Masukkan password" required>

            <button type="submit">
                <i class="bi bi-box-arrow-in-right me-1"></i> Login
            </button>
        </form>

        <p>Belum punya akun? <a href="{{ route('register') }}">Daftar Sekarang</a></p>
    </div>
</body>
</html>
