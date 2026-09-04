<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Reset Password — Gitania Skincare</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@400;600;700&family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }
        html, body { height: 100%; font-family: 'Poppins', sans-serif; }

        .rp-page {
            min-height: 100vh;
            background: linear-gradient(135deg, #F5F3FF 0%, #EDE9FE 50%, #DDD6FE 100%);
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 24px 16px;
        }

        .rp-card {
            background: #fff;
            border-radius: 24px;
            box-shadow: 0 20px 60px rgba(109, 40, 217, 0.15);
            padding: 44px 40px;
            width: 100%;
            max-width: 460px;
        }

        .rp-header {
            text-align: center;
            margin-bottom: 30px;
        }
        .rp-icon-wrap {
            width: 70px;
            height: 70px;
            background: linear-gradient(135deg, #8B5CF6, #7C3AED);
            border-radius: 20px;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 18px;
            box-shadow: 0 8px 24px rgba(124, 58, 237, .30);
        }
        .rp-brand {
            font-family: 'Playfair Display', serif;
            font-size: 13px;
            font-weight: 600;
            letter-spacing: 2px;
            color: #8B5CF6;
            text-transform: uppercase;
            margin-bottom: 6px;
        }
        .rp-title {
            font-family: 'Playfair Display', serif;
            font-size: 28px;
            font-weight: 700;
            color: #1a162b;
            margin-bottom: 8px;
        }
        .rp-desc {
            font-size: 13px;
            color: #665c75;
            line-height: 1.6;
        }

        .rp-field { margin-bottom: 18px; }
        .rp-label {
            display: block;
            font-size: 12.5px;
            font-weight: 600;
            color: #4a4058;
            margin-bottom: 7px;
        }
        .rp-input-wrap {
            position: relative;
            display: flex;
            align-items: center;
        }
        .rp-input-icon {
            position: absolute;
            left: 17px;
            color: #8B5CF6;
            display: flex;
            align-items: center;
            pointer-events: none;
        }
        .rp-field input {
            width: 100%;
            padding: 13px 44px 13px 48px;
            background: #FAF8FF;
            border: 1.5px solid #DDD6FE;
            border-radius: 12px;
            font-family: 'Poppins', sans-serif;
            font-size: 13.5px;
            color: #1a162b;
            outline: none;
            transition: border-color .2s, box-shadow .2s;
        }
        .rp-field input:focus {
            background: #fff;
            border-color: #8B5CF6;
            box-shadow: 0 0 0 3px rgba(139, 92, 246, .12);
        }
        .rp-field input::placeholder { color: #9CA3AF; }

        .eye-btn {
            position: absolute;
            right: 14px;
            background: none;
            border: none;
            color: #9CA3AF;
            cursor: pointer;
            padding: 4px;
            display: flex;
            align-items: center;
            transition: color .2s;
        }
        .eye-btn:hover { color: #7C3AED; }

        .rp-err {
            font-size: 11.5px;
            color: #DC2626;
            margin-top: 5px;
            display: block;
        }

        .rp-btn {
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
            margin-top: 6px;
        }
        .rp-btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 26px rgba(124, 58, 237, .40);
            opacity: .96;
        }

        @media (max-width: 480px) {
            .rp-card { padding: 32px 20px; }
        }
    </style>
</head>
<body>
<div class="rp-page">
    <div class="rp-card">

        <!-- Header -->
        <div class="rp-header">
            <div class="rp-icon-wrap">
                <svg width="30" height="30" fill="none" stroke="white" stroke-width="2" viewBox="0 0 24 24">
                    <path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"/>
                </svg>
            </div>
            <div class="rp-brand">Gitania Skincare</div>
            <h1 class="rp-title">Buat Password Baru</h1>
            <p class="rp-desc">Masukkan password baru yang kuat untuk akunmu.</p>
        </div>

        <form method="POST" action="{{ route('password.store') }}">
            @csrf
            <input type="hidden" name="token" value="{{ $request->route('token') }}">

            <!-- Email -->
            <div class="rp-field">
                <label class="rp-label" for="email">Alamat Email</label>
                <div class="rp-input-wrap">
                    <span class="rp-input-icon">
                        <svg width="17" height="17" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z"/>
                            <polyline points="22,6 12,13 2,6"/>
                        </svg>
                    </span>
                    <input type="email" id="email" name="email"
                           value="{{ old('email', $request->email) }}"
                           required autofocus autocomplete="username"
                           placeholder="Email Address">
                </div>
                @error('email') <span class="rp-err">{{ $message }}</span> @enderror
            </div>

            <!-- Password Baru -->
            <div class="rp-field">
                <label class="rp-label" for="password">Password Baru</label>
                <div class="rp-input-wrap">
                    <span class="rp-input-icon">
                        <svg width="17" height="17" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <rect x="3" y="11" width="18" height="11" rx="2"/>
                            <path d="M7 11V7a5 5 0 0 1 10 0v4"/>
                        </svg>
                    </span>
                    <input type="password" id="password" name="password"
                           required autocomplete="new-password"
                           placeholder="Min. 8 karakter">
                    <button type="button" class="eye-btn" onclick="togglePwd('password','eyeIcon1')" title="Tampilkan password">
                        <svg id="eyeIcon1" width="17" height="17" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/>
                            <circle cx="12" cy="12" r="3"/>
                        </svg>
                    </button>
                </div>
                @error('password') <span class="rp-err">{{ $message }}</span> @enderror
            </div>

            <!-- Konfirmasi Password -->
            <div class="rp-field">
                <label class="rp-label" for="password_confirmation">Konfirmasi Password</label>
                <div class="rp-input-wrap">
                    <span class="rp-input-icon">
                        <svg width="17" height="17" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"/>
                        </svg>
                    </span>
                    <input type="password" id="password_confirmation" name="password_confirmation"
                           required autocomplete="new-password"
                           placeholder="Ulangi password baru">
                    <button type="button" class="eye-btn" onclick="togglePwd('password_confirmation','eyeIcon2')" title="Tampilkan password">
                        <svg id="eyeIcon2" width="17" height="17" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/>
                            <circle cx="12" cy="12" r="3"/>
                        </svg>
                    </button>
                </div>
                @error('password_confirmation') <span class="rp-err">{{ $message }}</span> @enderror
            </div>

            <button type="submit" class="rp-btn">
                🔐 Reset Password Sekarang
            </button>
        </form>

    </div>
</div>

<script>
function togglePwd(inputId, iconId) {
    var input = document.getElementById(inputId);
    var icon  = document.getElementById(iconId);
    if (input.type === 'password') {
        input.type = 'text';
        icon.innerHTML = '<path d="M17.94 17.94A10.07 10.07 0 0 1 12 20c-7 0-11-8-11-8a18.45 18.45 0 0 1 5.06-5.94M9.9 4.24A9.12 9.12 0 0 1 12 4c7 0 11 8 11 8a18.5 18.5 0 0 1-2.16 3.19m-6.72-1.07a3 3 0 1 1-4.24-4.24"/><line x1="1" y1="1" x2="23" y2="23"/>';
    } else {
        input.type = 'password';
        icon.innerHTML = '<path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/><circle cx="12" cy="12" r="3"/>';
    }
}
</script>
</body>
</html>
