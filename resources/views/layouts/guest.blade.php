<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>Sistem Autentikasi — Toko Parabot Rafauzi</title>
    <link rel="icon" type="image/jpeg" href="{{ asset('images/logo-rafauzi.jpeg') }}">

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700&family=Sora:wght@400;600;700&display=swap" rel="stylesheet">

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }
        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
            background: #09090f; color: #e8e9f5;
            min-height: 100vh; display: flex; align-items: center; justify-content: center;
            position: relative; overflow-x: hidden; overflow-y: auto;
            padding: 40px 24px;
        }

        /* Custom Scrollbar */
        ::-webkit-scrollbar { width: 8px; }
        ::-webkit-scrollbar-track { background: transparent; }
        ::-webkit-scrollbar-thumb { background: rgba(255,255,255,0.1); border-radius: 10px; }
        ::-webkit-scrollbar-thumb:hover { background: rgba(255,255,255,0.2); }

        /* Abstract Background Decor */
        .bg-decor-1 {
            position: absolute; top: -150px; left: -100px;
            width: 400px; height: 400px; border-radius: 50%;
            background: rgba(99,102,241,0.15); filter: blur(100px); z-index: -1;
        }
        .bg-decor-2 {
            position: absolute; bottom: -150px; right: -100px;
            width: 400px; height: 400px; border-radius: 50%;
            background: rgba(139,92,246,0.15); filter: blur(100px); z-index: -1;
        }

        /* Auth Container */
        .auth-wrapper {
            width: 100%; max-width: 460px;
            background: rgba(19, 21, 31, 0.7);
            backdrop-filter: blur(20px); -webkit-backdrop-filter: blur(20px);
            border: 0.5px solid rgba(255,255,255,0.08);
            border-radius: 24px; padding: 48px;
            box-shadow: 0 24px 64px rgba(0,0,0,0.5);
            animation: fadeIn 0.6s ease forwards;
        }

        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(20px); }
            to { opacity: 1; transform: translateY(0); }
        }

        .auth-header {
            text-align: center; margin-bottom: 40px;
        }
        .auth-logo {
            width: 72px; height: 72px; border-radius: 20px;
            margin: 0 auto 20px;
            overflow: hidden; box-shadow: 0 12px 32px rgba(99,102,241,0.2);
            border: 0.5px solid rgba(255,255,255,0.1);
        }
        .auth-logo img {
            width: 100%; height: 100%; object-fit: cover;
        }
        .auth-title {
            font-family: 'Sora', sans-serif; font-size: 24px; font-weight: 700;
            color: #fff; margin-bottom: 8px; letter-spacing: -0.5px;
        }
        .auth-subtitle {
            font-size: 14px; color: #6e70a0;
        }

        /* Inputs & Forms Override */
        .auth-body form { display: flex; flex-direction: column; gap: 20px; }
        .auth-body label {
            display: block; font-size: 13px; font-weight: 500;
            color: #a5b4fc; margin-bottom: 8px;
        }
        .auth-body input[type="text"],
        .auth-body input[type="email"],
        .auth-body input[type="password"] {
            width: 100%; background: rgba(255,255,255,0.03);
            border: 0.5px solid rgba(255,255,255,0.08);
            border-radius: 12px; padding: 14px 16px;
            color: #fff; font-size: 15px; font-family: 'Plus Jakarta Sans', sans-serif;
            transition: border-color 0.2s, background 0.2s; outline: none;
        }
        .auth-body input:focus {
            border-color: #6366f1; background: rgba(99,102,241,0.05);
        }

        .auth-footer {
            display: flex; align-items: center; justify-content: space-between;
            margin-top: 24px; font-size: 13.5px;
        }
        .auth-link {
            color: #a5b4fc; text-decoration: none; transition: color 0.2s;
        }
        .auth-link:hover { color: #fff; }

        .btn-submit {
            width: 100%; padding: 14px; border-radius: 12px;
            background: linear-gradient(135deg, #6366f1, #8b5cf6);
            color: #fff; font-size: 15px; font-weight: 600;
            border: none; cursor: pointer; transition: transform 0.2s, opacity 0.2s;
            font-family: 'Plus Jakarta Sans', sans-serif;
            margin-top: 10px;
        }
        .btn-submit:hover { transform: translateY(-2px); opacity: 0.9; }

        /* Input Error */
        .input-error { color: #ef4444; font-size: 12px; margin-top: 6px; }

        @media (max-width: 480px) {
            .auth-wrapper { padding: 32px 24px; border-radius: 20px; border-color:transparent; background:transparent; box-shadow:none; max-height:100vh;}
        }
    </style>
</head>
<body>

    <div class="bg-decor-1"></div>
    <div class="bg-decor-2"></div>

    <div class="auth-wrapper">
        {{ $slot }}
    </div>

</body>
</html>
