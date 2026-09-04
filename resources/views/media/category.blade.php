<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ ucfirst($category) }} — Gitania Skincare</title>
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
        .cat-hero-wrap {
            position: relative;
            background: linear-gradient(135deg, #FBF9FF 0%, #F5ECFD 45%, #EBE0FA 100%);
            padding: 70px 24px 100px 24px;
            text-align: center;
            overflow: hidden;
        }
        .cat-hero-ambient {
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
        .cat-breadcrumb {
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
        .cat-breadcrumb a {
            color: var(--primary);
            text-decoration: none;
        }
        .cat-title {
            font-family: 'Playfair Display', serif;
            font-size: 44px;
            font-weight: 600;
            color: #1a162b;
            margin: 0 0 10px 0;
            text-transform: capitalize;
        }

        /* ===== PEMBATAS GELOMBANG ESTETIK ===== */
        .divider-wave-cat {
            position: relative;
            margin-top: -65px;
            line-height: 0;
            z-index: 3;
            overflow: hidden;
        }
        .divider-wave-cat svg {
            display: block;
            width: 100%;
            height: 65px;
        }
        .divider-wave-cat .fill-white {
            fill: #FFFFFF;
        }

        /* ===== POSTS GRID ===== */
        .posts-section {
            background: #FFFFFF;
            padding: 60px 24px 100px 24px;
            position: relative;
            z-index: 4;
        }
        .posts-container {
            max-width: 1140px;
            margin: 0 auto;
        }
        .article-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(320px, 1fr));
            gap: 30px;
        }
        .article-card {
            background: linear-gradient(145deg, #FFFFFF 0%, #FAF8FF 100%);
            border-radius: 24px;
            overflow: hidden;
            border: 1.5px solid rgba(221, 214, 254, 0.85);
            text-decoration: none;
            color: inherit;
            display: flex;
            flex-direction: column;
            box-shadow: 0 8px 25px rgba(107, 33, 168, 0.05);
            transition: transform 0.3s ease, box-shadow 0.3s ease, border-color 0.3s;
        }
        .article-card:hover {
            transform: translateY(-8px);
            box-shadow: 0 20px 45px rgba(107, 33, 168, 0.14);
            border-color: #A855F7;
        }
        .article-card-img-wrap {
            height: 210px;
            overflow: hidden;
            background: #EDE9FE;
        }
        .article-card-img-wrap img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            transition: transform 0.4s ease;
        }
        .article-card:hover .article-card-img-wrap img {
            transform: scale(1.06);
        }
        .article-card-body {
            padding: 24px;
            flex: 1;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
        }
        .article-date-pill {
            font-size: 11.5px;
            color: #7C3AED;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 0.8px;
            margin-bottom: 8px;
        }
        .article-card-title {
            font-family: 'Playfair Display', serif;
            font-size: 20px;
            font-weight: 600;
            color: #1a162b;
            line-height: 1.35;
            margin: 0 0 16px 0;
        }
        .article-read-link {
            font-size: 13px;
            font-weight: 700;
            color: var(--primary);
            display: inline-flex;
            align-items: center;
            gap: 6px;
        }

        @media (max-width: 768px) {
            .cat-hero-wrap { padding: 50px 18px 80px 18px; }
            .cat-title { font-size: 32px; }
            .posts-section { padding: 40px 18px 70px 18px; }
        }
    </style>
</head>
<body>
    @include('partials.navbar')

    <!-- ===== HERO SECTION ===== -->
    <div class="cat-hero-wrap">
        <div class="cat-hero-ambient"></div>
        <div style="position: relative; z-index: 2;">
            <div class="cat-breadcrumb">
                <a href="{{ route('media') }}">Media</a>
                <span>&gt;</span>
                <span style="color: var(--primary); font-weight: 700; text-transform: capitalize;">{{ $category }}</span>
            </div>
            <h1 class="cat-title">{{ $category }}</h1>
            <p style="color: #554a6b; font-size: 14.5px; max-width: 520px; margin: 0 auto;">
                Kumpulan artikel, tips perawatan kulit, dan wawasan resmi seputar kategori {{ $category }}.
            </p>
        </div>
    </div>

    <!-- ===== PEMBATAS GELOMBANG ESTETIK ===== -->
    <div class="divider-wave-cat">
        <svg viewBox="0 0 1440 80" preserveAspectRatio="none">
            <path d="M0,0 C320,65 640,75 960,35 C1200,5 1360,25 1440,40 L1440,80 L0,80 Z" class="fill-white"></path>
        </svg>
    </div>

    <!-- ===== POSTS SECTION ===== -->
    <section class="posts-section">
        <div class="posts-container">
            <div class="article-grid">
                @forelse($posts as $post)
                    <a href="{{ route('media.show', $post->slug) }}" class="article-card">
                        <div class="article-card-img-wrap">
                            <img src="{{ asset('storage/' . $post->thumbnail) }}" alt="{{ $post->title }}">
                        </div>
                        <div class="article-card-body">
                            <div>
                                <div class="article-date-pill">
                                    📅 {{ \Carbon\Carbon::parse($post->published_at)->format('d F Y') }}
                                </div>
                                <h3 class="article-card-title">{{ $post->title }}</h3>
                            </div>
                            <span class="article-read-link">Baca Selengkapnya →</span>
                        </div>
                    </a>
                @empty
                    <div style="grid-column: 1 / -1; text-align: center; padding: 70px 20px; background: #FAF8FF; border-radius: 24px; border: 1.5px solid #DDD6FE;">
                        <span style="font-size: 40px; display: block; margin-bottom: 10px;">📖</span>
                        <h3 style="font-family: 'Playfair Display', serif; font-size: 22px; color: #1a162b; margin: 0 0 6px 0;">Belum Ada Artikel</h3>
                        <p style="font-size: 14px; color: #665c75; margin: 0 0 18px 0;">Saat ini belum ada artikel yang dipublikasikan pada kategori ini.</p>
                        <a href="{{ route('media') }}" class="btn-outline" style="padding: 10px 24px; border-radius: 999px; font-size: 13px; text-decoration: none;">← Kembali ke Media</a>
                    </div>
                @endforelse
            </div>
        </div>
    </section>

    @include('partials.footer')
    @include('partials.chatbot')
</body>
</html>
