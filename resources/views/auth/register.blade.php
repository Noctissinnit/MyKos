<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar - MyKos</title>

    <!-- Bootstrap Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">

    <style>
        * {
            box-sizing: border-box;
            font-family: "Poppins", sans-serif;
        }

        body {
            background: #F8F9FB;
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
            margin: 0;
        }

        .register-card {
            width: 100%;
            max-width: 480px;
            background: #fff;
            padding: 45px 40px;
            border-radius: 24px;
            box-shadow: 0px 9px 20px rgba(0, 0, 0, 0.15);
        }

        .logo {
            display: block;
            margin: 0 auto 25px;
            width: 130px;
        }

        label {
            font-weight: 600;
            margin-bottom: 6px;
            color: #222;
            font-size: 14px;
            display: block;
        }

        .form-input,
        .form-select {
            width: 100%;
            padding: 14px 16px;
            border-radius: 14px;
            border: 1px solid #dcdcdc;
            background: #f3f3f3;
            font-size: 14px;
            outline: none;
            transition: 0.2s;
        }

        .form-input:focus,
        .form-select:focus {
            background: #fff;
            border-color: #3D63A9;
            box-shadow: 0 0 4px rgba(61, 99, 169, 0.3);
        }

        .select-wrapper {
            position: relative;
        }

        .select-wrapper i {
            position: absolute;
            right: 16px;
            top: 50%;
            transform: translateY(-50%);
            font-size: 16px;
            color: #555;
            pointer-events: none;
        }

        .btn-submit {
            width: 100%;
            padding: 14px;
            margin-top: 25px;
            border: none;
            background: #3D63A9;
            color: white;
            font-weight: 600;
            border-radius: 14px;
            cursor: pointer;
            font-size: 15px;
            display: flex;
            justify-content: center;
            align-items: center;
            gap: 8px;
            transition: 0.2s ease;
        }

        .btn-submit:hover {
            background: #365a98;
        }

        p {
            text-align: center;
            margin-top: 20px;
            font-size: 14px;
            color: #444;
        }

        p a {
            color: #3D63A9;
            font-weight: 600;
            text-decoration: none;
        }

        p a:hover {
            text-decoration: underline;
        }
    </style>
</head>

<body>

<div class="register-card">

    <img src="{{ asset('img/logomykos.png') }}" class="logo" alt="Logo">

    <form method="POST" action="{{ url('/register') }}">
        @csrf

        <label>Nama</label>
        <input type="text" name="name" class="form-input" placeholder="Masukkan nama anda" required>

        <label>Email</label>
        <input type="email" name="email" class="form-input" placeholder="Masukkan email anda" required>

        <label>Password</label>
        <input type="password" name="password" class="form-input" placeholder="Masukkan password anda" required>

        <label>Konfirmasi Password</label>
        <input type="password" name="password_confirmation" class="form-input" placeholder="Masukkan password anda" required>

        <label>Kamu mau jadi apa?</label>
        <div class="select-wrapper">
            <select name="role" class="form-select" required>
                <option value="">Pilih Role</option>
                <option value="user">User</option>
                <option value="pemilik">Pemilik Kos</option>
                <option value="admin">Admin</option>
            </select>
            <i class="bi bi-chevron-down"></i>
        </div>

        <button class="btn-submit" type="submit">
            <i class="bi bi-box-arrow-in-right"></i> Daftar
        </button>
    </form>

    <p>Sudah punya akun? <a href="{{ url('/login') }}">Login Sini</a></p>

</div>

</body>
</html>
