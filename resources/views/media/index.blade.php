<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Media &amp; Berita — Gitania Skincare</title>
    <!-- Google Fonts: Poppins & Playfair Display -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:ital,wght@0,400;0,500;0,600;0,700;1,400&family=Poppins:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        :root {
            --purple-deep: #4a2e7a;
            --primary: #6B21A8;
            --primary-dark: #581C87;
            --primary-pale: #F5F3FF;
            --primary-soft: #EDE9FE;
            --primary-border: #DDD6FE;
            --text-dark: #1a162b;
            --accent-pink: #b93863;
        }
        body { font-family: 'Poppins', sans-serif; margin: 0; background: #FFFFFF; color: var(--text-dark); }

        /* ===== HERO SECTION ===== */
        .media-hero-wrap {
            position: relative;
            background: linear-gradient(135deg, #FBF9FF 0%, #F5ECFD 45%, #EBE0FA 100%);
            padding: 85px 24px 110px 24px;
            text-align: center;
            overflow: hidden;
        }
        .media-hero-ambient {
            position: absolute;
            top: -100px;
            left: 50%;
            transform: translateX(-50%);
            width: 600px;
            height: 600px;
            background: radial-gradient(circle, rgba(168, 85, 247, 0.15) 0%, rgba(221, 214, 254, 0.05) 50%, transparent 70%);
            border-radius: 50%;
            pointer-events: none;
            z-index: 1;
        }
        .media-hero-content {
            position: relative;
            z-index: 2;
            max-width: 800px;
            margin: 0 auto;
        }
        .media-pill-tag {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            background: white;
            color: var(--primary);
            padding: 8px 22px;
            border-radius: 999px;
            font-size: 11px;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 1.5px;
            border: 1.5px solid var(--primary-border);
            margin-bottom: 20px;
            box-shadow: 0 4px 18px rgba(107, 33, 168, 0.07);
        }
        .media-hero-title {
            font-family: 'Playfair Display', serif;
            font-size: 48px;
            font-weight: 600;
            color: #1a162b;
            line-height: 1.18;
            margin: 0 0 16px 0;
            letter-spacing: -0.5px;
        }
        .media-hero-title span {
            background: linear-gradient(135deg, #6B21A8 0%, #9333EA 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
        }
        .media-hero-desc {
            font-family: 'Poppins', sans-serif;
            color: #524765;
            font-size: 15px;
            line-height: 1.85;
            max-width: 580px;
            margin: 0 auto;
            font-weight: 400;
        }

        /* ===== PEMBATAS 1: WAVE DIVIDER DARI HERO KE TOPICS ===== */
        .divider-wave-media {
            position: relative;
            margin-top: -65px;
            line-height: 0;
            z-index: 3;
            overflow: hidden;
        }
        .divider-wave-media svg {
            display: block;
            width: 100%;
            height: 65px;
        }
        .divider-wave-media .fill-white {
            fill: #FFFFFF;
        }

        /* ===== TOPICS SECTION ===== */
        .media-topics-section {
            background: #FFFFFF;
            padding: 60px 24px 80px 24px;
            position: relative;
            z-index: 4;
        }
        .media-topics-container {
            max-width: 1100px;
            margin: 0 auto;
        }
        .media-section-header {
            text-align: center;
            max-width: 650px;
            margin: 0 auto 40px auto;
        }
        .media-section-heading {
            font-family: 'Playfair Display', serif;
            font-size: 36px;
            font-weight: 600;
            color: #1a162b;
            margin: 0 0 10px 0;
        }
        .media-section-sub {
            color: #665c75;
            font-size: 14px;
            margin: 0;
        }

        /* Topic Cards Grid */
        .topics-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 32px;
        }
        .topic-card {
            background: linear-gradient(145deg, #FFFFFF 0%, #FAF8FF 100%);
            border-radius: 26px;
            overflow: hidden;
            border: 1.5px solid rgba(221, 214, 254, 0.85);
            text-decoration: none;
            color: inherit;
            box-shadow: 0 10px 30px rgba(107, 33, 168, 0.06);
            transition: transform 0.35s ease, box-shadow 0.35s ease, border-color 0.3s;
            display: flex;
            flex-direction: column;
        }
        .topic-card:hover {
            transform: translateY(-8px);
            box-shadow: 0 22px 50px rgba(107, 33, 168, 0.15);
            border-color: #A855F7;
        }
        .topic-card-img-wrap {
            height: 230px;
            overflow: hidden;
            background: #EDE9FE;
            position: relative;
        }
        .topic-card-img-wrap img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            transition: transform 0.4s ease;
        }
        .topic-card:hover .topic-card-img-wrap img {
            transform: scale(1.06);
        }
        .topic-card-body {
            padding: 26px;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        .topic-card-title {
            font-family: 'Playfair Display', serif;
            font-size: 22px;
            font-weight: 600;
            color: #1a162b;
            margin: 0 0 6px 0;
        }
        .topic-card-sub {
            font-size: 12.5px;
            color: #7C3AED;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.8px;
        }
        .topic-card-arrow {
            width: 42px;
            height: 42px;
            background: #F5F3FF;
            color: var(--primary);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 16px;
            font-weight: 700;
            border: 1px solid var(--primary-border);
            transition: background 0.2s, color 0.2s;
        }
        .topic-card:hover .topic-card-arrow {
            background: var(--primary);
            color: white;
        }

        /* ===== CURVED BRAND & INSTAGRAM SECTION (LACTACYD STYLE) ===== */
        .ig-media-curved-section {
            position: relative;
            background: linear-gradient(180deg, #FBF8FF 0%, #F5ECFD 45%, #EBE0FA 100%);
            padding: 90px 20px 70px 20px;
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
            height: 65px;
        }
        .ig-top-curve .shape-fill {
            fill: #FFFFFF;
        }

        .ig-brand-title {
            font-family: 'Playfair Display', serif;
            font-size: 42px;
            font-weight: 500;
            color: #1a162b;
            text-align: center;
            margin: 0 0 8px 0;
            letter-spacing: -0.5px;
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

        @media (max-width: 768px) {
            .media-hero-wrap { padding: 60px 18px 90px 18px; }
            .media-hero-title { font-size: 34px; }
            .topics-grid { grid-template-columns: 1fr; }
            .media-topics-section { padding: 40px 18px 60px 18px; }
        }
    </style>
</head>
<body>
    @include('partials.navbar')

    <!-- ===== 1. HERO SECTION ===== -->
    <div class="media-hero-wrap">
        <div class="media-hero-ambient"></div>
        <div class="media-hero-content">
            <span class="media-pill-tag">
                ✨ Media, News &amp; Spotlight
            </span>
            <h1 class="media-hero-title">
                Jelajahi Inspirasi,<br>
                <span>Berita &amp; Cerita Gitania</span>
            </h1>
            <p class="media-hero-desc">
                Temukan kabar terbaru, edukasi kesehatan kulit, peluncuran produk klinis, dan sorotan kegiatan resmi Gitania Skincare.
            </p>
        </div>
    </div>

    <!-- ===== PEMBATAS 1: LENGKUNGAN GELOMBANG ESTETIK (HERO -> TOPICS) ===== -->
    <div class="divider-wave-media">
        <svg viewBox="0 0 1440 80" preserveAspectRatio="none">
            <path d="M0,0 C320,65 640,75 960,35 C1200,5 1360,25 1440,40 L1440,80 L0,80 Z" class="fill-white"></path>
        </svg>
    </div>

    <!-- ===== 2. EXPLORE BY TOPIC SECTION ===== -->
    <section class="media-topics-section">
        <div class="media-topics-container">
            
            <div class="media-section-header">
                <span class="media-pill-tag" style="margin-bottom: 12px;">Kategori Media</span>
                <h2 class="media-section-heading">Explore by Topic</h2>
                <p class="media-section-sub">Pilih kategori untuk membaca artikel dan berita seputar Gitania Skincare</p>
            </div>

            <div class="topics-grid">
                <!-- Kotak 1: News -->
                <a href="{{ route('media.category', 'news') }}" class="topic-card">
                    <div class="topic-card-img-wrap">
                        <img src="https://images.unsplash.com/photo-1573496359142-b8d87734a5a2?auto=format&fit=crop&w=600&q=80" alt="News Gitania Skincare">
                    </div>
                    <div class="topic-card-body">
                        <div>
                            <div class="topic-card-sub">Berita Terkini</div>
                            <h3 class="topic-card-title">News</h3>
                        </div>
                        <div class="topic-card-arrow">→</div>
                    </div>
                </a>

                <!-- Kotak 2: Gitania Spotlight -->
                <a href="{{ route('media.category', 'spotlight') }}" class="topic-card">
                    <div class="topic-card-img-wrap">
                        <img src="https://images.unsplash.com/photo-1522335789203-aabd1fc54bc9?auto=format&fit=crop&w=600&q=80" alt="Gitania Spotlight">
                    </div>
                    <div class="topic-card-body">
                        <div>
                            <div class="topic-card-sub">Sorotan &amp; Event</div>
                            <h3 class="topic-card-title">Gitania Spotlight</h3>
                        </div>
                        <div class="topic-card-arrow">→</div>
                    </div>
                </a>
            </div>

        </div>
    </section>

    <!-- ===== 3. CURVED BRAND & INSTAGRAM SECTION (LACTACYD STYLE) ===== -->
    <div class="ig-media-curved-section">
        <!-- Lengkungan Scoop Halus di Bagian Atas -->
        <div class="ig-top-curve">
            <svg viewBox="0 0 1440 120" preserveAspectRatio="none">
                <path d="M0,0 L1440,0 L1440,5 C960,105 480,105 0,5 Z" class="shape-fill"></path>
            </svg>
        </div>

        <div style="max-width: 1200px; margin: 0 auto; position: relative; z-index: 3;">
            <div style="text-align: center; margin-bottom: 32px;">
                <h2 class="ig-brand-title">Gitania Skincare</h2>
                <p style="color: #6B21A8; font-size: 14px; font-weight: 600; margin: 0 0 16px 0; letter-spacing: 0.5px;">@gitaniaskincare</p>
                <div style="display: flex; justify-content: center; gap: 12px; margin-bottom: 24px;">
                    <a href="https://www.instagram.com" target="_blank" style="color: var(--primary); font-weight: 600; font-size: 13px; text-decoration: none; display: inline-flex; align-items: center; gap: 6px; background: white; padding: 9px 24px; border-radius: 999px; border: 1.5px solid rgba(221, 214, 254, 0.9); box-shadow: 0 4px 12px rgba(107,33,168,0.06); transition: 0.2s;">
                        📸 Follow Us on Instagram →
                    </a>
                </div>
            </div>

            <!-- Mengambil data langsung dari database tabel media -->
            @php
                $mediaItems = \App\Models\Media::latest()->get();
            @endphp

            <div class="insta-scroll-container">
                @forelse($mediaItems as $item)
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

    @include('partials.footer')
    @include('partials.chatbot')
</body>
</html>
