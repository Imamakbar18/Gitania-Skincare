<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Sign In — Gitania Skincare</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@400;500;600;700&family=Poppins:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        * { box-sizing: border-box; margin: 0; padding: 0; }

        html, body {
            height: 100%;
            font-family: 'Poppins', sans-serif;
            background: #fff;
        }

        /* ─── LAYOUT: 2 KOLOM ─── */
        .login-wrap {
            display: grid;
            grid-template-columns: 1fr 1fr;
            min-height: 100vh;
        }

        /* ─── SISI KIRI: FOTO PRODUK (JELAS, TIDAK RUSAK) ─── */
        .login-left {
            position: relative;
            overflow: hidden;
        }
        /* Gunakan <img> bukan background agar gambar terlihat lebih tajam & proporsional */
        .login-left img.panel-photo {
            width: 100%;
            height: 100%;
            object-fit: cover;
            object-position: center center;
            display: block;
        }

        /* ─── SISI KANAN: FORM ─── */
        .login-right {
            background: #fff;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            padding: 48px 40px;
            position: relative;
        }

        .form-box {
            width: 100%;
            max-width: 400px;
        }

        /* Brand Header */
        .brand-wrap {
            text-align: center;
            margin-bottom: 28px;
        }
        .brand-name {
            font-family: 'Playfair Display', serif;
            font-size: 28px;
            font-weight: 700;
            color: #1a162b;
            letter-spacing: 2.5px;
        }
        .brand-tag {
            font-size: 11px;
            color: #665c75;
            margin-top: 3px;
        }

        /* Judul */
        .form-title {
            font-family: 'Playfair Display', serif;
            font-size: 36px;
            font-weight: 600;
            color: #1a162b;
            text-align: center;
            margin-bottom: 6px;
        }
        .form-subtitle {
            font-size: 13.5px;
            color: #665c75;
            text-align: center;
            margin-bottom: 32px;
        }

        /* Input Field */
        .field { margin-bottom: 16px; }
        .field-row {
            position: relative;
            display: flex;
            align-items: center;
        }
        .field-icon {
            position: absolute;
            left: 17px;
            color: #8B5CF6;
            display: flex;
            align-items: center;
            pointer-events: none;
        }
        .field input[type="email"],
        .field input[type="password"],
        .field input[type="text"] {
            width: 100%;
            padding: 13px 44px 13px 46px;
            background: #FAF8FF;
            border: 1.5px solid #DDD6FE;
            border-radius: 12px;
            font-family: 'Poppins', sans-serif;
            font-size: 13.5px;
            color: #1a162b;
            outline: none;
            transition: border-color .2s, box-shadow .2s;
        }
        .field input:focus {
            background: #fff;
            border-color: #8B5CF6;
            box-shadow: 0 0 0 3px rgba(139,92,246,.11);
        }
        .field input::placeholder { color: #9CA3AF; }
        .eye-btn {
            position: absolute;
            right: 15px;
            background: none;
            border: none;
            color: #9CA3AF;
            cursor: pointer;
            display: flex;
            align-items: center;
            padding: 4px;
            transition: color .2s;
        }
        .eye-btn:hover { color: #6B21A8; }
        .err-msg {
            display: block;
            font-size: 11.5px;
            color: #DC2626;
            margin-top: 5px;
        }

        /* Options Row */
        .opts-row {
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin-bottom: 22px;
            font-size: 13px;
        }
        .remember-lbl {
            display: flex;
            align-items: center;
            gap: 7px;
            color: #4a4058;
            cursor: pointer;
            user-select: none;
        }
        .remember-lbl input[type="checkbox"] {
            width: 15px; height: 15px;
            accent-color: #7C3AED;
            cursor: pointer;
        }
        .forgot-lnk {
            color: #554a6b;
            text-decoration: none;
            font-weight: 500;
        }
        .forgot-lnk:hover { color: #6B21A8; text-decoration: underline; }

        /* Tombol Sign In */
        .btn-signin {
            width: 100%;
            padding: 14px;
            background: linear-gradient(135deg, #C4A0F8 0%, #8B5CF6 55%, #7C3AED 100%);
            border: none;
            border-radius: 12px;
            color: #fff;
            font-family: 'Poppins', sans-serif;
            font-size: 14.5px;
            font-weight: 700;
            cursor: pointer;
            box-shadow: 0 6px 20px rgba(139,92,246,.30);
            transition: transform .22s, box-shadow .22s, opacity .22s;
        }
        .btn-signin:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 26px rgba(139,92,246,.40);
            opacity: .96;
        }

        /* Tombol Google */
        .btn-google {
            width: 100%;
            margin-top: 13px;
            padding: 13px;
            background: #fff;
            border: 1.5px solid #DDD6FE;
            border-radius: 12px;
            font-family: 'Poppins', sans-serif;
            font-size: 13.5px;
            font-weight: 600;
            color: #374151;
            cursor: pointer;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 10px;
            text-decoration: none;
            transition: background .2s, border-color .2s, transform .2s;
        }
        .btn-google:hover {
            background: #FAF8FF;
            border-color: #8B5CF6;
            color: #1a162b;
            transform: translateY(-2px);
        }

        /* Footer */
        .footer-prompt {
            text-align: center;
            margin-top: 26px;
            font-size: 13px;
            color: #665c75;
        }
        .create-lnk {
            color: #1a162b;
            font-weight: 700;
            text-decoration: underline;
            margin-left: 3px;
        }
        .create-lnk:hover { color: #6B21A8; }

        /* Back pill */
        .back-pill {
            position: absolute;
            top: 22px; right: 22px;
            display: inline-flex;
            align-items: center;
            gap: 6px;
            background: #FAF8FF;
            border: 1px solid #DDD6FE;
            padding: 6px 16px;
            border-radius: 999px;
            font-size: 12px;
            font-weight: 600;
            color: #6B21A8;
            text-decoration: none;
            transition: background .2s;
        }
        .back-pill:hover { background: #EDE9FE; }

        /* Status */
        .status-box {
            margin-bottom: 18px;
            font-size: 13px;
            color: #16A34A;
            background: #F0FDF4;
            border: 1px solid #BBF7D0;
            padding: 10px 14px;
            border-radius: 10px;
            text-align: center;
        }

        /* ─── RESPONSIVE ─── */
        @media (max-width: 900px) {
            .login-wrap { grid-template-columns: 1fr; }
            .login-left {
                height: 260px;
            }
            .login-left img.panel-photo {
                object-position: center 30%;
            }
            .login-right { padding: 36px 20px 60px; }
        }
    </style>
</head>
<body>

<div class="login-wrap">

    <!-- ===== SISI KIRI: FOTO PRODUK GITANIA ===== -->
    <div class="login-left">
        <img
            class="panel-photo"
            src="{{ asset('images/login-panel.jpg') }}?v={{ filemtime(public_path('images/login-panel.jpg')) }}"
            alt="Gitania Skincare – Glow Naturally, Feel Beautiful"
        >
    </div>

    <!-- ===== SISI KANAN: FORM LOGIN ===== -->
    <div class="login-right">

        <a href="{{ route('home') }}" class="back-pill">← Beranda</a>

        <div class="form-box">

            <!-- Logo Brand -->
            <div class="brand-wrap">
                <div class="brand-name">GITANIA</div>
                <div class="brand-tag">Glow Naturally, Feel Beautiful.</div>
            </div>

            <!-- Heading -->
            <h1 class="form-title">Welcome Back</h1>
            <p class="form-subtitle">Sign in to continue your skincare journey.</p>

            <!-- Status pesan sukses (e.g. reset password) -->
            @if (session('status'))
                <div class="status-box">{{ session('status') }}</div>
            @endif

            <!-- Form -->
            <form method="POST" action="{{ route('login') }}">
                @csrf

                <!-- Email -->
                <div class="field">
                    <div class="field-row">
                        <span class="field-icon">
                            <svg width="17" height="17" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                <path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z"/>
                                <polyline points="22,6 12,13 2,6"/>
                            </svg>
                        </span>
                        <input type="email" id="email" name="email" value="{{ old('email') }}"
                               required autofocus autocomplete="username"
                               placeholder="Email Address">
                    </div>
                    @error('email')
                        <span class="err-msg">{{ $message }}</span>
                    @enderror
                </div>

                <!-- Password -->
                <div class="field">
                    <div class="field-row">
                        <span class="field-icon">
                            <svg width="17" height="17" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                <rect x="3" y="11" width="18" height="11" rx="2" ry="2"/>
                                <path d="M7 11V7a5 5 0 0 1 10 0v4"/>
                            </svg>
                        </span>
                        <input type="password" id="loginPwd" name="password"
                               required autocomplete="current-password"
                               placeholder="Password">
                        <button type="button" class="eye-btn" onclick="togglePwd()" title="Toggle password">
                            <svg id="eyeIcon" width="18" height="18" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                <path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/>
                                <circle cx="12" cy="12" r="3"/>
                            </svg>
                        </button>
                    </div>
                    @error('password')
                        <span class="err-msg">{{ $message }}</span>
                    @enderror
                </div>

                <!-- Remember & Forgot -->
                <div class="opts-row">
                    <label class="remember-lbl">
                        <input type="checkbox" name="remember">
                        <span>Remember me</span>
                    </label>
                    @if (Route::has('password.request'))
                        <a href="{{ route('password.request') }}" class="forgot-lnk">Forgot Password?</a>
                    @endif
                </div>

                <!-- Sign In Button -->
                <button type="submit" class="btn-signin">Sign In</button>

                <!-- Continue with Google -->
                <a href="{{ url('/auth/google') }}" class="btn-google">
                    <svg width="18" height="18" viewBox="0 0 24 24">
                        <path fill="#4285F4" d="M22.56 12.25c0-.78-.07-1.53-.2-2.25H12v4.26h5.92c-.26 1.37-1.04 2.53-2.21 3.31v2.77h3.57c2.08-1.92 3.28-4.74 3.28-8.09z"/>
                        <path fill="#34A853" d="M12 23c2.97 0 5.46-.98 7.28-2.66l-3.57-2.77c-.98.66-2.23 1.06-3.71 1.06-2.86 0-5.29-1.93-6.16-4.53H2.18v2.84C3.99 20.53 7.7 23 12 23z"/>
                        <path fill="#FBBC05" d="M5.84 14.09c-.22-.66-.35-1.36-.35-2.09s.13-1.43.35-2.09V7.06H2.18C1.43 8.55 1 10.22 1 12s.43 3.45 1.18 4.94l2.85-2.22.81-.63z"/>
                        <path fill="#EA4335" d="M12 5.38c1.62 0 3.06.56 4.21 1.64l3.15-3.15C17.45 2.09 14.97 1 12 1 7.7 1 3.99 3.47 2.18 7.06l3.66 2.84c.87-2.6 3.3-4.52 6.16-4.52z"/>
                    </svg>
                    <span>Continue with Google</span>
                </a>

                <!-- Create Account Link -->
                <div class="footer-prompt">
                    Don't have an account?
                    <a href="{{ route('register') }}" class="create-lnk">Create Account</a>
                </div>

            </form>
        </div>
    </div>

</div>

<script>
    function togglePwd() {
        const input = document.getElementById('loginPwd');
        const icon  = document.getElementById('eyeIcon');
        if (input.type === 'password') {
            input.type = 'text';
            icon.innerHTML = `
                <path d="M17.94 17.94A10.07 10.07 0 0 1 12 20c-7 0-11-8-11-8a18.45 18.45 0 0 1 5.06-5.94M9.9 4.24A9.12 9.12 0 0 1 12 4c7 0 11 8 11 8a18.5 18.5 0 0 1-2.16 3.19m-6.72-1.07a3 3 0 1 1-4.24-4.24"/>
                <line x1="1" y1="1" x2="23" y2="23"/>
            `;
        } else {
            input.type = 'password';
            icon.innerHTML = `
                <path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/>
                <circle cx="12" cy="12" r="3"/>
            `;
        }
    }
</script>
</body>
</html>
