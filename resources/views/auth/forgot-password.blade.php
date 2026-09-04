<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Lupa Password — Gitania Skincare</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@400;600;700&family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }
        html, body { height: 100%; font-family: 'Poppins', sans-serif; }

        .fp-page {
            min-height: 100vh;
            background: linear-gradient(135deg, #F5F3FF 0%, #EDE9FE 50%, #DDD6FE 100%);
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 24px 16px;
        }

        .fp-card {
            background: #fff;
            border-radius: 24px;
            box-shadow: 0 20px 60px rgba(109, 40, 217, 0.15);
            padding: 44px 40px;
            width: 100%;
            max-width: 440px;
            text-align: center;
        }

        .fp-icon-wrap {
            width: 70px;
            height: 70px;
            background: linear-gradient(135deg, #8B5CF6, #7C3AED);
            border-radius: 20px;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 20px;
            box-shadow: 0 8px 24px rgba(124, 58, 237, 0.30);
        }

        .fp-brand {
            font-family: 'Playfair Display', serif;
            font-size: 14px;
            font-weight: 600;
            letter-spacing: 2px;
            color: #8B5CF6;
            text-transform: uppercase;
            margin-bottom: 6px;
        }

        .fp-title {
            font-family: 'Playfair Display', serif;
            font-size: 28px;
            font-weight: 700;
            color: #1a162b;
            margin-bottom: 10px;
        }

        .fp-desc {
            font-size: 13.5px;
            color: #665c75;
            line-height: 1.65;
            margin-bottom: 28px;
        }

        .fp-status {
            background: #F0FDF4;
            border: 1px solid #BBF7D0;
            color: #16A34A;
            font-size: 13px;
            padding: 12px 16px;
            border-radius: 12px;
            margin-bottom: 20px;
            text-align: left;
            line-height: 1.55;
        }

        .fp-field {
            position: relative;
            margin-bottom: 18px;
        }
        .fp-field .fp-icon {
            position: absolute;
            left: 17px;
            top: 50%;
            transform: translateY(-50%);
            color: #8B5CF6;
            display: flex;
            align-items: center;
            pointer-events: none;
        }
        .fp-field input {
            width: 100%;
            padding: 13px 16px 13px 48px;
            background: #FAF8FF;
            border: 1.5px solid #DDD6FE;
            border-radius: 12px;
            font-family: 'Poppins', sans-serif;
            font-size: 13.5px;
            color: #1a162b;
            outline: none;
            transition: border-color .2s, box-shadow .2s;
            text-align: left;
        }
        .fp-field input:focus {
            background: #fff;
            border-color: #8B5CF6;
            box-shadow: 0 0 0 3px rgba(139, 92, 246, .12);
        }
        .fp-field input::placeholder { color: #9CA3AF; }

        .fp-err {
            font-size: 11.5px;
            color: #DC2626;
            text-align: left;
            margin-top: 5px;
            display: block;
        }

        .fp-btn {
            width: 100%;
            padding: 14px;
            background: linear-gradient(135deg, #8B5CF6, #7C3AED);
            border: none;
            border-radius: 12px;
            color: #fff;
            font-family: 'Poppins', sans-serif;
            font-size: 14.5px;
            font-weight: 700;
            cursor: pointer;
            box-shadow: 0 6px 20px rgba(124, 58, 237, .30);
            transition: transform .22s, box-shadow .22s, opacity .22s;
            margin-top: 4px;
        }
        .fp-btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 26px rgba(124, 58, 237, .40);
            opacity: .96;
        }

        .fp-back {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            margin-top: 22px;
            font-size: 13px;
            color: #665c75;
            text-decoration: none;
            font-weight: 500;
            transition: color .2s;
        }
        .fp-back:hover { color: #7C3AED; }

        @media (max-width: 480px) {
            .fp-card { padding: 32px 22px; }
        }
    </style>
</head>
<body>
<div class="fp-page">
    <div class="fp-card">

        <!-- Icon -->
        <div class="fp-icon-wrap">
            <svg width="30" height="30" fill="none" stroke="white" stroke-width="2" viewBox="0 0 24 24">
                <rect x="3" y="11" width="18" height="11" rx="2"/>
                <path d="M7 11V7a5 5 0 0 1 10 0v4"/>
            </svg>
        </div>

        <div class="fp-brand">Gitania Skincare</div>
        <h1 class="fp-title">Lupa Password?</h1>
        <p class="fp-desc">
            Tenang! Masukkan email yang terdaftar di akunmu.<br>
            Kami akan mengirimkan link untuk reset password.
        </p>

        <!-- Status sukses setelah kirim -->
        @if (session('status'))
            <div class="fp-status">
                ✅ {{ session('status') }}<br>
                <small style="color:#15803D;">Cek inbox (dan folder spam) emailmu.</small>
            </div>
        @endif

        <form method="POST" action="{{ route('password.email') }}">
            @csrf

            <div class="fp-field">
                <span class="fp-icon">
                    <svg width="17" height="17" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z"/>
                        <polyline points="22,6 12,13 2,6"/>
                    </svg>
                </span>
                <input type="email" name="email" id="email"
                       value="{{ old('email') }}"
                       required autofocus
                       placeholder="Email Address (gmail/yahoo)">
            </div>
            @error('email')
                <span class="fp-err">{{ $message }}</span>
            @enderror

            <button type="submit" class="fp-btn">
                Kirim Link Reset Password
            </button>
        </form>

        <a href="{{ route('login') }}" class="fp-back">
            ← Kembali ke halaman Login
        </a>

    </div>
</div>
</body>
</html>
