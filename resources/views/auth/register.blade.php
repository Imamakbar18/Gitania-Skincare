<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Create Account — Gitania Skincare</title>
    <!-- Google Fonts: Poppins & Playfair Display -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:ital,wght@0,400;0,500;0,600;0,700;1,400&family=Poppins:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        :root {
            --primary: #6B21A8;
            --primary-dark: #581C87;
            --primary-mid: #7C3AED;
            --primary-light: #A855F7;
            --lilac-soft: #EDE9FE;
            --lilac-pale: #F5F3FF;
            --lilac-border: #DDD6FE;
            --text-dark: #1a162b;
            --text-muted: #665c75;
        }

        *, *::before, *::after {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
        }

        body {
            font-family: 'Poppins', sans-serif;
            background: #FFFFFF;
            color: var(--text-dark);
            min-height: 100vh;
        }

        /* ===== SPLIT LAYOUT (MATCHING LOGIN MOCKUP) ===== */
        .register-split-wrapper {
            display: grid;
            grid-template-columns: 1fr 1fr;
            min-height: 100vh;
            width: 100%;
        }

        /* ===== LEFT COLUMN: PHOTOSHOOT BANNER (FULL COVER) ===== */
        .register-visual-side {
            position: relative;
            background: url('{{ asset('images/login-banner.jpg') }}?v={{ filemtime(public_path('images/login-banner.jpg')) }}') center center / cover no-repeat;
            display: flex;
            flex-direction: column;
            justify-content: flex-end;
            padding: 40px;
            overflow: hidden;
        }

        /* ===== RIGHT COLUMN: REGISTER FORM ===== */
        .register-form-side {
            background: #FFFFFF;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 50px 40px;
            position: relative;
        }
        .register-form-container {
            width: 100%;
            max-width: 440px;
        }

        .form-brand-header {
            text-align: center;
            margin-bottom: 24px;
        }
        .form-brand-header .logo-main-title {
            font-size: 28px;
        }

        .register-welcome-title {
            font-family: 'Playfair Display', serif;
            font-size: 34px;
            font-weight: 600;
            color: #1a162b;
            text-align: center;
            margin: 0 0 8px 0;
            letter-spacing: -0.5px;
        }
        .register-welcome-subtitle {
            font-family: 'Poppins', sans-serif;
            font-size: 13.5px;
            color: #665c75;
            text-align: center;
            margin: 0 0 28px 0;
        }

        /* Input Controls */
        .input-group {
            margin-bottom: 16px;
        }
        .input-control-wrap {
            position: relative;
            display: flex;
            align-items: center;
        }
        .input-icon-left {
            position: absolute;
            left: 18px;
            color: #8B5CF6;
            font-size: 15px;
            pointer-events: none;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        .register-input-field {
            width: 100%;
            padding: 13px 45px 13px 48px;
            background: #FAF8FF;
            border: 1.5px solid rgba(221, 214, 254, 0.9);
            border-radius: 12px;
            font-family: 'Poppins', sans-serif;
            font-size: 13.5px;
            color: var(--text-dark);
            outline: none;
            transition: all 0.25s ease;
        }
        .register-input-field:focus {
            background: #FFFFFF;
            border-color: #8B5CF6;
            box-shadow: 0 0 0 3px rgba(139, 92, 246, 0.12);
        }
        .register-input-field::placeholder {
            color: #9CA3AF;
        }

        /* Primary Sign Up Button */
        .btn-register-primary {
            width: 100%;
            padding: 14px;
            background: linear-gradient(135deg, #B588F2 0%, #8B5CF6 50%, #7C3AED 100%);
            border: none;
            border-radius: 12px;
            color: white;
            font-family: 'Poppins', sans-serif;
            font-size: 14.5px;
            font-weight: 700;
            cursor: pointer;
            box-shadow: 0 6px 20px rgba(139, 92, 246, 0.32);
            transition: transform 0.25s ease, box-shadow 0.25s ease, opacity 0.25s ease;
            margin-top: 8px;
        }
        .btn-register-primary:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 24px rgba(139, 92, 246, 0.42);
            opacity: 0.96;
        }

        .signin-prompt-footer {
            text-align: center;
            margin-top: 24px;
            font-size: 13px;
            color: #665c75;
        }
        .login-account-link {
            color: #1a162b;
            font-weight: 700;
            text-decoration: underline;
            margin-left: 4px;
            transition: color 0.2s;
        }
        .login-account-link:hover {
            color: #6B21A8;
        }

        .field-error-msg {
            color: #DC2626;
            font-size: 12px;
            margin-top: 4px;
            display: block;
        }

        .back-home-pill {
            position: absolute;
            top: 24px;
            right: 24px;
            display: inline-flex;
            align-items: center;
            gap: 6px;
            background: #FAF8FF;
            border: 1px solid var(--lilac-border);
            padding: 6px 16px;
            border-radius: 999px;
            font-size: 12px;
            font-weight: 600;
            color: var(--primary);
            text-decoration: none;
            transition: all 0.2s;
        }
        .back-home-pill:hover {
            background: var(--lilac-soft);
        }

        @media (max-width: 900px) {
            .register-split-wrapper {
                grid-template-columns: 1fr;
                min-height: auto;
            }
            .register-visual-side {
                padding: 40px 24px 20px 24px;
                min-height: 260px;
                text-align: center;
            }
            .register-brand-header {
                display: flex;
                justify-content: center;
            }
            .register-hero-image-wrap {
                max-width: 300px;
            }
            .register-form-side {
                padding: 40px 20px 60px 20px;
            }
            .form-brand-header {
                display: none;
            }
            .register-welcome-title {
                font-size: 28px;
            }
        }
    </style>
</head>
<body>

    <div class="register-split-wrapper">

        <!-- ===== 1. LEFT SIDE: PHOTOSHOOT BANNER (FULL COVER) ===== -->
        <div class="register-visual-side">
            <!-- Foto 2 mengisi 100% penuh area kiri dengan cover center -->
        </div>

        <!-- ===== 2. RIGHT SIDE: REGISTER FORM ===== -->
        <div class="register-form-side">
            
            <a href="{{ route('home') }}" class="back-home-pill">
                ← Kembali ke Beranda
            </a>

            <div class="register-form-container">

                <div class="form-brand-header">
                    <div class="brand-logo-text">
                        <span class="logo-main-title">GITANIA</span>
                        <span class="logo-tagline">Glow Naturally, Feel Beautiful.</span>
                    </div>
                </div>

                <h1 class="register-welcome-title">Create Account</h1>
                <p class="register-welcome-subtitle">Join us and start your healthy skincare journey.</p>

                <form method="POST" action="{{ route('register') }}">
                    @csrf

                    <!-- Name -->
                    <div class="input-group">
                        <div class="input-control-wrap">
                            <span class="input-icon-left">
                                <svg width="17" height="17" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                    <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"/>
                                    <circle cx="12" cy="7" r="4"/>
                                </svg>
                            </span>
                            <input id="name" type="text" name="name" value="{{ old('name') }}" required autofocus autocomplete="name" placeholder="Full Name" class="register-input-field">
                        </div>
                        @error('name')
                            <span class="field-error-msg">{{ $message }}</span>
                        @enderror
                    </div>

                    <!-- Email Address -->
                    <div class="input-group">
                        <div class="input-control-wrap">
                            <span class="input-icon-left">
                                <svg width="17" height="17" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                    <path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z"/>
                                    <polyline points="22,6 12,13 2,6"/>
                                </svg>
                            </span>
                            <input id="email" type="email" name="email" value="{{ old('email') }}" required autocomplete="username" placeholder="Email Address" class="register-input-field">
                        </div>
                        @error('email')
                            <span class="field-error-msg">{{ $message }}</span>
                        @enderror
                    </div>

                    <!-- Password -->
                    <div class="input-group">
                        <div class="input-control-wrap">
                            <span class="input-icon-left">
                                <svg width="17" height="17" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                    <rect x="3" y="11" width="18" height="11" rx="2" ry="2"/>
                                    <path d="M7 11V7a5 5 0 0 1 10 0v4"/>
                                </svg>
                            </span>
                            <input id="password" type="password" name="password" required autocomplete="new-password" placeholder="Password (Min. 8 characters)" class="register-input-field">
                        </div>
                        @error('password')
                            <span class="field-error-msg">{{ $message }}</span>
                        @enderror
                    </div>

                    <!-- Confirm Password -->
                    <div class="input-group">
                        <div class="input-control-wrap">
                            <span class="input-icon-left">
                                <svg width="17" height="17" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                    <path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"/>
                                </svg>
                            </span>
                            <input id="password_confirmation" type="password" name="password_confirmation" required autocomplete="new-password" placeholder="Confirm Password" class="register-input-field">
                        </div>
                        @error('password_confirmation')
                            <span class="field-error-msg">{{ $message }}</span>
                        @enderror
                    </div>

                    <!-- Submit Button -->
                    <button type="submit" class="btn-register-primary">
                        Create Account
                    </button>

                    <!-- Footer Link -->
                    <div class="signin-prompt-footer">
                        Already have an account? <a href="{{ route('login') }}" class="login-account-link">Sign In</a>
                    </div>
                </form>

            </div>
        </div>

    </div>

</body>
</html>
