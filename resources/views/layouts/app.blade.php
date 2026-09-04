<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" style="scroll-behavior: smooth;">
<head>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta charset="utf-8">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('title', config('app.name', 'Gitania Skincare'))</title>

    <!-- Google Fonts: Poppins & Playfair Display -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:ital,wght@0,400;0,500;0,600;0,700;1,400&family=Poppins:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">

    <!-- Vite Assets -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        /* ===== CSS VARIABLES — GITANIA THEME ===== */
        :root {
            --primary:        #6B21A8;   /* ungu utama */
            --primary-dark:   #581C87;   /* ungu gelap (hover) */
            --primary-light:  #7C3AED;   /* violet */
            --primary-pale:   #F5F3FF;   /* bg ungu pucat */
            --primary-soft:   #EDE9FE;   /* border/card ungu */
            --primary-border: #DDD6FE;   /* border lembut */
            --white:          #FFFFFF;
            --bg:             #FAFAFA;
            --text-dark:      #1E1B4B;   /* indigo-950 */
            --text-body:      #374151;
            --text-muted:     #6B7280;
            --accent:         #9333EA;
            /* Legacy compat */
            --purple-deep:    #6B21A8;
            --lilac-soft:     #EDE9FE;
            --lilac-light:    #F5F3FF;
            --text-dark-old:  #1E1B4B;
            --accent-pink:    #7C3AED;
        }

        /* ===== RESET & BASE ===== */
        *, *::before, *::after { box-sizing: border-box; }

        body {
            font-family: 'Poppins', sans-serif;
            background: var(--bg);
            margin: 0;
            color: var(--text-body);
            overflow-x: hidden;
            line-height: 1.6;
        }

        /* ===== UTILITY CLASSES ===== */
        .btn-primary {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            background: var(--primary);
            color: white;
            padding: 12px 28px;
            border-radius: 999px;
            font-weight: 600;
            font-size: 14px;
            text-decoration: none;
            border: none;
            cursor: pointer;
            transition: background 0.2s, transform 0.15s;
        }
        .btn-primary:hover {
            background: var(--primary-dark);
            transform: translateY(-1px);
        }
        .btn-outline {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            background: transparent;
            color: var(--primary);
            padding: 11px 28px;
            border-radius: 999px;
            font-weight: 600;
            font-size: 14px;
            text-decoration: none;
            border: 2px solid var(--primary-border);
            cursor: pointer;
            transition: background 0.2s, border-color 0.2s;
        }
        .btn-outline:hover {
            background: var(--primary-pale);
            border-color: var(--primary);
        }

        /* ===== CARD BASE ===== */
        .gtn-card {
            background: white;
            border-radius: 18px;
            border: 1px solid var(--primary-soft);
            box-shadow: 0 4px 20px rgba(107, 33, 168, 0.05);
        }

        /* ===== CURVED BRAND & INSTAGRAM SECTION (LACTACYD STYLE) ===== */
        .ig-section {
            position: relative;
            background: linear-gradient(180deg, #FBF8FF 0%, #F5ECFD 45%, #EBE0FA 100%);
            padding: 100px 20px 70px 20px;
            margin-top: 60px;
            overflow: hidden;
        }
        .ig-top-curve {
            position: absolute;
            top: -1px;
            left: 0;
            width: 100%;
            overflow: hidden;
            line-height: 0;
            z-index: 2;
            pointer-events: none;
        }
        .ig-top-curve svg {
            position: relative;
            display: block;
            width: calc(100% + 1.3px);
            height: 70px;
        }
        .ig-top-curve .shape-fill {
            fill: var(--bg, #FAFAFA);
        }
        .ig-section-inner {
            max-width: 1280px;
            margin: 0 auto;
            position: relative;
            z-index: 3;
        }
        .ig-brand-title {
            font-family: 'Playfair Display', serif;
            font-size: 44px;
            font-weight: 500;
            color: #1a162b;
            text-align: center;
            margin: 0 0 10px 0;
            letter-spacing: -0.5px;
        }
        .ig-header {
            text-align: center;
            margin-bottom: 36px;
        }

        /* Style untuk Instagram Feed Horizontal */
        .insta-scroll-container {
            display: flex;
            gap: 20px;
            overflow-x: auto;
            padding-bottom: 20px;
            scrollbar-width: thin;
            scrollbar-color: rgba(107, 33, 168, 0.2) transparent;
            max-width: 1200px;
            margin: 0 auto;
        }
        .insta-scroll-container::-webkit-scrollbar {
            height: 6px;
        }
        .insta-scroll-container::-webkit-scrollbar-thumb {
            background-color: rgba(107, 33, 168, 0.2);
            border-radius: 10px;
        }
        .insta-card {
            flex: 0 0 240px;
            background: white;
            border-radius: 20px;
            overflow: hidden;
            border: 1.5px solid rgba(221, 214, 254, 0.8);
            text-decoration: none;
            color: inherit;
            box-shadow: 0 6px 22px rgba(74, 46, 122, 0.05);
            display: flex;
            flex-direction: column;
            transition: all 0.28s ease;
        }
        .insta-card:hover {
            transform: translateY(-6px);
            box-shadow: 0 16px 36px rgba(107, 33, 168, 0.15);
        }

        /* ===== FOOTER ===== */
        .gtn-footer {
            background: white;
            border-top: 1px solid var(--primary-soft);
            padding: 60px 20px 30px 20px;
        }
        .gtn-footer-inner {
            max-width: 1280px;
            margin: 0 auto;
            display: grid;
            grid-template-columns: 1.8fr 1fr 1fr 1.5fr;
            gap: 40px;
        }
        .gtn-footer-bottom {
            max-width: 1280px;
            margin: 40px auto 0 auto;
            padding-top: 24px;
            border-top: 1px solid var(--primary-soft);
            display: flex;
            justify-content: space-between;
            align-items: center;
            flex-wrap: wrap;
            gap: 12px;
            font-size: 12px;
            color: var(--text-muted);
        }
        .footer-link {
            text-decoration: none;
            color: var(--primary);
            font-weight: 600;
            font-size: 12px;
            transition: color 0.2s;
        }
        .footer-link:hover { color: var(--primary-dark); }
        .footer-nav-link {
            text-decoration: none;
            color: var(--text-muted);
            font-size: 13px;
            font-weight: 500;
            transition: color 0.2s;
            display: block;
            padding: 3px 0;
        }
        .footer-nav-link:hover { color: var(--primary); }
        .footer-heading {
            color: var(--text-dark);
            font-weight: 700;
            font-size: 12px;
            letter-spacing: 1.2px;
            text-transform: uppercase;
            margin-bottom: 18px;
        }
        .payment-badge {
            background: var(--primary-pale);
            color: var(--primary);
            padding: 4px 10px;
            border-radius: 6px;
            border: 1px solid var(--primary-soft);
            font-size: 11px;
            font-weight: 600;
        }

        /* ===== RESPONSIVE FOOTER ===== */
        @media (max-width: 1024px) {
            .gtn-footer-inner {
                grid-template-columns: 1fr 1fr;
            }
            .ig-grid {
                grid-template-columns: repeat(3, 1fr);
            }
        }
        @media (max-width: 640px) {
            .gtn-footer-inner {
                grid-template-columns: 1fr;
                gap: 32px;
            }
            .ig-grid {
                grid-template-columns: repeat(2, 1fr);
            }
            .ig-section { padding: 40px 16px; margin-top: 60px; }
            .gtn-footer { padding: 40px 16px 24px 16px; }
        }
    </style>
</head>
<body>

<div class="min-h-screen" style="background: var(--bg);">

    <!-- Navbar -->
    @include('partials.navbar')

    <!-- Page Header (opsional) -->
    @isset($header)
        <header style="background: white; border-bottom: 1px solid var(--primary-soft); padding: 20px 24px;">
            <div style="max-width: 1280px; margin: 0 auto;">
                {{ $header }}
            </div>
        </header>
    @endisset

    <!-- Konten Halaman -->
    <main>
        @yield('content')
    </main>
</div>

<!-- ===== SECTION INSTAGRAM & FOOTER (Hanya di Halaman Publik) ===== -->
@unless(request()->is('admin*'))

    <!-- Curved Brand & Instagram Section (Lactacyd Style) -->
    <div class="ig-section">
        <!-- Lengkungan Scoop Halus di Bagian Atas (Persis Foto 1) -->
        <div class="ig-top-curve">
            <svg viewBox="0 0 1440 120" preserveAspectRatio="none">
                <path d="M0,0 L1440,0 L1440,5 C960,105 480,105 0,5 Z" class="shape-fill"></path>
            </svg>
        </div>

        <div class="ig-section-inner">
            <div class="ig-header">
                <h2 class="ig-brand-title">Gitania Skincare</h2>
                <p style="color: #6B21A8; font-size: 14px; font-weight: 600; margin: 0 0 12px 0; letter-spacing: 0.5px;">@gitaniaskincare</p>
                <div style="display: flex; justify-content: center; gap: 12px; margin-bottom: 24px;">
                    <a href="https://instagram.com" target="_blank" style="color: var(--primary); font-weight: 600; font-size: 13px; text-decoration: none; display: inline-flex; align-items: center; gap: 6px; background: white; padding: 9px 24px; border-radius: 999px; border: 1.5px solid var(--primary-border); box-shadow: 0 4px 12px rgba(107,33,168,0.06);">
                        📸 Follow Us on Instagram →
                    </a>
                </div>
            </div>
            <!-- Mengambil data langsung dari database tabel media (sinkron dengan panel admin) -->
            @php
                $gtnMediaItems = \App\Models\Media::latest()->get();
            @endphp

            <div class="insta-scroll-container">
                @forelse($gtnMediaItems as $item)
                    <a href="{{ $item->instagram_link }}" target="_blank" class="insta-card">
                        <div style="width: 100%; height: 220px; overflow: hidden; background: #eee; position: relative;">
                            <img src="{{ asset('storage/' . $item->thumbnail) }}" alt="{{ $item->title }}" style="width: 100%; height: 100%; object-fit: cover;">
                            <div style="position: absolute; top: 10px; right: 10px; background: rgba(0,0,0,0.45); backdrop-filter: blur(4px); color: white; width: 28px; height: 28px; border-radius: 50%; display: flex; align-items: center; justify-content: center; font-size: 12px;">
                                📸
                            </div>
                        </div>
                        <div style="padding: 18px; flex: 1; display: flex; flex-direction: column; justify-content: space-between;">
                            <h3 style="font-size: 13px; margin: 0 0 12px 0; color: var(--text-dark); font-weight: 600; line-height: 1.4; display: -webkit-box; -webkit-line-clamp: 2; -webkit-box-orient: vertical; overflow: hidden;">
                                {{ $item->title }}
                            </h3>
                            <span style="font-size: 12px; font-weight: 700; color: var(--primary);">View Post &rarr;</span>
                        </div>
                    </a>
                @empty
                    <div style="width: 100%; text-align: center; padding: 50px 20px; background: white; border-radius: 20px; border: 1.5px solid rgba(221, 214, 254, 0.8);">
                        <p style="font-size: 14px; color: #665c75; font-weight: 500; margin: 0;">Belum ada postingan Instagram yang ditambahkan admin.</p>
                    </div>
                @endforelse
            </div>
        </div>
    </div>

    <!-- Footer Utama -->
    <footer class="gtn-footer">
        <div class="gtn-footer-inner">

            <!-- Kolom 1: Logo & Deskripsi -->
            <div>
                <img src="{{ asset('images/logo-gitania.jpg') }}" alt="Gitania Skincare" style="height: 72px; width: auto; object-fit: contain; margin-bottom: 14px; border-radius: 8px;">
                <p style="color: var(--text-muted); font-size: 13px; line-height: 1.7; margin: 0 0 16px 0; max-width: 260px;">
                    Clinical-grade skincare untuk kulit sehat, cerah, dan bercahaya setiap hari.
                </p>
                <div style="display: flex; gap: 10px;">
                    <a href="#" style="width: 34px; height: 34px; background: var(--primary-pale); border: 1px solid var(--primary-border); border-radius: 8px; display: flex; align-items: center; justify-content: center; color: var(--primary); font-weight: 700; font-size: 14px; text-decoration: none;">f</a>
                    <a href="#" style="width: 34px; height: 34px; background: var(--primary-pale); border: 1px solid var(--primary-border); border-radius: 8px; display: flex; align-items: center; justify-content: center; color: var(--primary); font-weight: 700; font-size: 14px; text-decoration: none;">ig</a>
                    <a href="#" style="width: 34px; height: 34px; background: var(--primary-pale); border: 1px solid var(--primary-border); border-radius: 8px; display: flex; align-items: center; justify-content: center; color: var(--primary); font-weight: 700; font-size: 14px; text-decoration: none;">tt</a>
                </div>
            </div>

            <!-- Kolom 2: Informasi -->
            <div>
                <div class="footer-heading">Informasi</div>
                <nav style="display: flex; flex-direction: column; gap: 2px;">
                    <a href="{{ route('profile.index') }}" class="footer-nav-link">My Account</a>
                    <a href="#" class="footer-nav-link">Reseller Resmi Gitania</a>
                    <a href="{{ route('about') }}" class="footer-nav-link">Tentang Gitania</a>
                    <a href="#" class="footer-nav-link">Cek Keaslian Produk</a>
                    <a href="#" class="footer-nav-link">Umroh Bareng Gitania</a>
                </nav>
            </div>

            <!-- Kolom 3: Layanan -->
            <div>
                <div class="footer-heading">Layanan Pelanggan</div>
                <nav style="display: flex; flex-direction: column; gap: 2px;">
                    <a href="{{ route('contact') }}" class="footer-nav-link">Hubungi Kami</a>
                    <a href="#" class="footer-nav-link">FAQ</a>
                    <a href="#" class="footer-nav-link">Kebijakan Pengembalian</a>
                    <a href="#" class="footer-nav-link">Syarat & Ketentuan</a>
                </nav>
                <div style="margin-top: 16px;">
                    <div class="footer-heading" style="margin-bottom: 6px;">Email CS</div>
                    <a href="mailto:cs@gitania.id" class="footer-nav-link" style="color: var(--primary); font-weight: 600;">cs@gitania.id</a>
                </div>
            </div>

            <!-- Kolom 4: Metode Pembayaran -->
            <div>
                <div class="footer-heading">Metode Pembayaran</div>
                <div style="margin-bottom: 10px;">
                    <div style="font-size: 11px; font-weight: 600; color: var(--text-muted); margin-bottom: 6px;">Transfer Bank</div>
                    <div style="display: flex; gap: 6px; flex-wrap: wrap;">
                        <span class="payment-badge">BCA</span>
                        <span class="payment-badge">BRI</span>
                        <span class="payment-badge">Mandiri</span>
                        <span class="payment-badge">BNI</span>
                        <span class="payment-badge">BSI</span>
                    </div>
                </div>
                <div style="margin-bottom: 10px;">
                    <div style="font-size: 11px; font-weight: 600; color: var(--text-muted); margin-bottom: 6px;">E-Wallet</div>
                    <div style="display: flex; gap: 6px; flex-wrap: wrap;">
                        <span class="payment-badge">QRIS</span>
                        <span class="payment-badge">GoPay</span>
                        <span class="payment-badge">OVO</span>
                        <span class="payment-badge">Dana</span>
                    </div>
                </div>
                <div>
                    <div style="font-size: 11px; font-weight: 600; color: var(--text-muted); margin-bottom: 6px;">Minimarket</div>
                    <div style="display: flex; gap: 6px; flex-wrap: wrap;">
                        <span class="payment-badge">Indomaret</span>
                        <span class="payment-badge">Alfamart</span>
                    </div>
                </div>
            </div>

        </div>

        <!-- Footer Bottom -->
        <div class="gtn-footer-bottom">
            <div>© {{ date('Y') }} Gitania Skincare. All rights reserved.</div>
            <div style="display: flex; gap: 20px;">
                <a href="#" class="footer-link">Terms</a>
                <a href="#" class="footer-link">Privacy</a>
            </div>
        </div>
    </footer>
@endunless

<!-- Chatbot Component -->
@include('partials.chatbot')

<!-- Script Global Keranjang -->
<script>
    function toggleCart() {
        const sidebar = document.getElementById('cartSidebar');
        const overlay = document.getElementById('cartOverlay');
        if (!sidebar || !overlay) return;
        const isOpen = sidebar.style.right === '0px';
        sidebar.style.right = isOpen ? '-100%' : '0px';
        overlay.style.display = isOpen ? 'none' : 'block';
        if (!isOpen) refreshCartDrawer();
    }

    function refreshCartDrawer() {
        fetch("{{ route('cart.data') }}")
            .then(r => r.json())
            .then(data => {
                const el = document.getElementById('cartDrawerContainer');
                if (el) el.innerHTML = data.html;
            })
            .catch(e => console.error('Cart error:', e));
    }
</script>
</body>
</html>
