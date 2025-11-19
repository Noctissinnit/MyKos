<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar - Sistem Kos</title>

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

        .register-container {
            background: #fff;
            border-radius: 16px;
            padding: 40px 35px;
            width: 100%;
            max-width: 450px;
            box-shadow: 0 6px 18px rgba(0, 0, 0, 0.08);
            animation: fadeIn 0.5s ease;
        }

        h2 {
            color: #222;
            text-align: center;
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

        input[type="text"],
        input[type="email"],
        input[type="password"],
        select {
            width: 100%;
            padding: 12px 14px;
            margin-top: 6px;
            border: 1px solid #ddd;
            border-radius: 10px;
            background-color: #fafafa;
            transition: all 0.2s ease;
        }

        input:focus,
        select:focus {
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
            background-color: #f8d7da;
            color: #721c24;
            border: 1px solid #f5c6cb;
            padding: 10px;
            border-radius: 8px;
            margin-bottom: 15px;
            font-size: 0.9rem;
        }

        p {
            margin-top: 20px;
            text-align: center;
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
            display: block;
            font-size: 40px;
            color: #0d6efd;
            text-align: center;
            margin-bottom: 10px;
        }

        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(10px); }
            to { opacity: 1; transform: translateY(0); }
        }
    </style>
</head>
<body>
    <div class="register-container">
        <i class="bi bi-person-plus icon"></i>
        <h2>Daftar Akun</h2>

        @if ($errors->any())
            <div class="alert">
                <ul style="margin:0;padding-left:20px;text-align:left;">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form method="POST" action="{{ url('/register') }}">
            @csrf

            <label for="name">Nama</label>
            <input type="text" id="name" name="name" placeholder="Masukkan nama Anda" required>

            <label for="email">Email</label>
            <input type="email" id="email" name="email" placeholder="Masukkan email Anda" required>

            <label for="password">Password</label>
            <input type="password" id="password" name="password" placeholder="Masukkan password" required>

            <label for="password_confirmation">Konfirmasi Password</label>
            <input type="password" id="password_confirmation" name="password_confirmation" placeholder="Ulangi password" required>

            <label for="role">Pilih Role</label>
            <select id="role" name="role" required>
                <option value="">-- Pilih Role --</option>
                <option value="user">User</option>
                <option value="pemilik">Pemilik Kos</option>
                <option value="admin">Admin</option>
            </select>

            <button type="submit">
                <i class="bi bi-check-circle me-1"></i> Daftar
            </button>
        </form>

        <p>Sudah punya akun? <a href="{{ url('/login') }}">Login di sini</a></p>
    </div>
</body>
</html>
