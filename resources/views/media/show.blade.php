<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $post->title }} — Gitania Skincare</title>
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

        /* ===== HERO HEADER ===== */
        .show-hero-wrap {
            position: relative;
            background: linear-gradient(135deg, #FBF9FF 0%, #F5ECFD 45%, #EBE0FA 100%);
            padding: 70px 24px 100px 24px;
            text-align: center;
            overflow: hidden;
        }
        .show-hero-ambient {
            position: absolute;
            top: -100px;
            left: 50%;
            transform: translateX(-50%);
            width: 550px;
            height: 550px;
            background: radial-gradient(circle, rgba(168, 85, 247, 0.14) 0%, transparent 70%);
            border-radius: 50%;
            pointer-events: none;
        }
        .show-breadcrumb {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            background: white;
            padding: 6px 18px;
            border-radius: 999px;
            font-size: 12px;
            font-weight: 600;
            color: #665c75;
            border: 1px solid var(--primary-border);
            margin-bottom: 16px;
            box-shadow: 0 2px 10px rgba(107,33,168,0.05);
        }
        .show-breadcrumb a {
            color: var(--primary);
            text-decoration: none;
        }
        .show-title {
            font-family: 'Playfair Display', serif;
            font-size: 40px;
            font-weight: 600;
            color: #1a162b;
            line-height: 1.25;
            margin: 0 auto 12px auto;
            max-width: 860px;
        }
        .show-meta-pill {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            font-size: 12.5px;
            color: #7C3AED;
            font-weight: 600;
        }

        /* ===== PEMBATAS GELOMBANG ESTETIK ===== */
        .divider-wave-show {
            position: relative;
            margin-top: -65px;
            line-height: 0;
            z-index: 3;
            overflow: hidden;
        }
        .divider-wave-show svg {
            display: block;
            width: 100%;
            height: 65px;
        }
        .divider-wave-show .fill-white {
            fill: #FFFFFF;
        }

        /* ===== ARTICLE BODY CONTENT ===== */
        .article-content-section {
            background: #FFFFFF;
            padding: 50px 24px 100px 24px;
            position: relative;
            z-index: 4;
        }
        .article-container {
            max-width: 860px;
            margin: 0 auto;
        }
        .article-main-image {
            width: 100%;
            max-height: 480px;
            border-radius: 28px;
            overflow: hidden;
            border: 2px solid rgba(221, 214, 254, 0.85);
            box-shadow: 0 16px 45px rgba(107, 33, 168, 0.12);
            margin-bottom: 40px;
        }
        .article-main-image img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            display: block;
        }
        .article-body-card {
            background: linear-gradient(145deg, #FFFFFF 0%, #FAF8FF 100%);
            border-radius: 26px;
            border: 1.5px solid rgba(221, 214, 254, 0.8);
            padding: 45px;
            box-shadow: 0 10px 30px rgba(107, 33, 168, 0.04);
            font-size: 15.5px;
            line-height: 1.9;
            color: #4a4058;
        }

        @media (max-width: 768px) {
            .show-hero-wrap { padding: 50px 18px 80px 18px; }
            .show-title { font-size: 28px; }
            .article-body-card { padding: 26px 20px; font-size: 14.5px; }
        }
    </style>
</head>
<body>
    @include('partials.navbar')

    <!-- ===== HERO HEADER ===== -->
    <div class="show-hero-wrap">
        <div class="show-hero-ambient"></div>
        <div style="position: relative; z-index: 2; max-width: 900px; margin: 0 auto;">
            <div class="show-breadcrumb">
                <a href="{{ route('media') }}">Media</a>
                <span>&gt;</span>
                <a href="{{ route('media.category', $post->category) }}" style="text-transform: capitalize;">{{ $post->category }}</a>
            </div>
            <h1 class="show-title">{{ $post->title }}</h1>
            <div class="show-meta-pill">
                <span>📅</span> {{ \Carbon\Carbon::parse($post->published_at)->format('d F Y') }}
                <span>•</span>
                <span>✨ Gitania Skincare Official</span>
            </div>
        </div>
    </div>

    <!-- ===== PEMBATAS GELOMBANG ESTETIK ===== -->
    <div class="divider-wave-show">
        <svg viewBox="0 0 1440 80" preserveAspectRatio="none">
            <path d="M0,0 C320,65 640,75 960,35 C1200,5 1360,25 1440,40 L1440,80 L0,80 Z" class="fill-white"></path>
        </svg>
    </div>

    <!-- ===== ARTICLE CONTENT ===== -->
    <section class="article-content-section">
        <div class="article-container">
            
            <!-- Foto Utama -->
            <div class="article-main-image">
                <img src="{{ asset('storage/' . $post->thumbnail) }}" alt="{{ $post->title }}">
            </div>

            <!-- Isi Artikel -->
            <div class="article-body-card">
                {!! nl2br(e($post->content)) !!}
            </div>

            <div style="margin-top: 35px; text-align: center;">
                <a href="{{ route('media') }}" class="btn-outline" style="padding: 12px 28px; border-radius: 999px; font-size: 13.5px; font-weight: 600; text-decoration: none; display: inline-flex; align-items: center; gap: 8px;">
                    ← Kembali ke Semua Media
                </a>
            </div>

        </div>
    </section>

    @include('partials.footer')
    @include('partials.chatbot')
</body>
</html>
