<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Our Products — Gitania Skincare</title>
    <!-- Google Fonts: Poppins & Playfair Display -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:ital,wght@0,400;0,500;0,600;0,700;1,400&family=Poppins:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        :root {
            --purple:        #6B21A8;
            --purple-dark:   #581C87;
            --purple-mid:    #7C3AED;
            --lilac:         #A855F7;
            --lilac-soft:    #EDE9FE;
            --lilac-pale:    #F5F3FF;
            --lilac-border:  #DDD6FE;
            --white:         #FFFFFF;
            --bg:            #FFFFFF;
            --text:          #1a162b;
            --text-body:     #374151;
            --text-muted:    #6B7280;
            --text-light:    #9CA3AF;
        }
        *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }
        body {
            font-family: 'Poppins', sans-serif;
            background: #F5F3FF;
            color: var(--text-body);
            overflow-x: hidden;
        }

        /* ===== HERO HEADER BANNER ===== */
        .shop-hero-wrap {
            position: relative;
            background: linear-gradient(135deg, #FBF9FF 0%, #F5ECFD 45%, #EBE0FA 100%);
            padding: 85px 24px 110px 24px;
            text-align: center;
            overflow: hidden;
        }
        .shop-hero-ambient {
            position: absolute;
            top: -120px;
            left: 50%;
            transform: translateX(-50%);
            width: 650px;
            height: 650px;
            background: radial-gradient(circle, rgba(168, 85, 247, 0.15) 0%, rgba(221, 214, 254, 0.05) 50%, transparent 70%);
            border-radius: 50%;
            pointer-events: none;
            z-index: 1;
        }
        .shop-hero-content {
            position: relative;
            z-index: 2;
            max-width: 800px;
            margin: 0 auto;
        }
        .shop-pill-tag {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            background: white;
            color: var(--purple);
            padding: 8px 22px;
            border-radius: 999px;
            font-size: 11px;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 1.5px;
            border: 1.5px solid var(--lilac-border);
            margin-bottom: 20px;
            box-shadow: 0 4px 18px rgba(107, 33, 168, 0.07);
        }
        .shop-hero-title {
            font-family: 'Playfair Display', serif;
            font-size: 50px;
            font-weight: 600;
            color: #1a162b;
            line-height: 1.18;
            margin: 0 0 16px 0;
            letter-spacing: -0.5px;
        }
        .shop-hero-title span {
            background: linear-gradient(135deg, #6B21A8 0%, #9333EA 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
        }
        .shop-hero-desc {
            font-family: 'Poppins', sans-serif;
            color: #524765;
            font-size: 15px;
            line-height: 1.85;
            max-width: 580px;
            margin: 0 auto;
            font-weight: 400;
        }

        /* ===== PEMBATAS GELOMBANG ESTETIK ===== */
        .divider-wave-shop {
            position: relative;
            margin-top: -65px;
            line-height: 0;
            z-index: 3;
            overflow: hidden;
        }
        .divider-wave-shop svg {
            display: block;
            width: 100%;
            height: 65px;
        }
        .divider-wave-shop .fill-white {
            fill: #FFFFFF;
        }

        /* ===== QUICK CATEGORY CHIPS BAR ===== */
        .quick-chips-wrap {
            max-width: 1340px;
            margin: 0 auto 30px auto;
            padding: 0 24px;
            display: flex;
            gap: 10px;
            overflow-x: auto;
            scrollbar-width: none;
        }
        .quick-chips-wrap::-webkit-scrollbar { display: none; }
        .chip-pill {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            background: #FAF8FF;
            color: #554a6b;
            padding: 8px 18px;
            border-radius: 999px;
            font-size: 12.5px;
            font-weight: 600;
            text-decoration: none;
            border: 1.5px solid rgba(221, 214, 254, 0.85);
            white-space: nowrap;
            transition: all 0.2s ease;
        }
        .chip-pill:hover {
            background: var(--lilac-soft);
            color: var(--purple);
            border-color: var(--purple);
        }
        .chip-pill.active {
            background: var(--purple);
            color: white;
            border-color: var(--purple);
            box-shadow: 0 4px 14px rgba(107, 33, 168, 0.25);
        }

        /* ===== MAIN LAYOUT ===== */
        .shop-page {
            max-width: 1340px;
            margin: 0 auto;
            padding: 0 24px 90px;
            display: grid;
            grid-template-columns: 270px 1fr;
            gap: 32px;
            align-items: start;
            position: relative;
            z-index: 4;
        }

        /* ===== SIDEBAR FILTER ===== */
        .filter-panel {
            background: linear-gradient(145deg, #FFFFFF 0%, #FAF8FF 100%);
            border-radius: 24px;
            border: 1.5px solid rgba(221, 214, 254, 0.85);
            box-shadow: 0 8px 30px rgba(107, 33, 168, 0.05);
            overflow: hidden;
            position: sticky;
            top: 84px;
        }
        .filter-panel-header {
            background: linear-gradient(135deg, var(--purple) 0%, var(--purple-mid) 100%);
            padding: 18px 22px;
            display: flex;
            align-items: center;
            gap: 10px;
        }
        .filter-panel-header h3 {
            color: white;
            font-size: 14px;
            font-weight: 700;
            letter-spacing: 0.5px;
        }
        .filter-panel-body { padding: 22px; }

        .filter-section { margin-bottom: 24px; }
        .filter-section:last-child { margin-bottom: 0; }
        .filter-section-title {
            font-size: 11px;
            font-weight: 800;
            color: var(--purple);
            text-transform: uppercase;
            letter-spacing: 1.2px;
            margin-bottom: 12px;
            display: flex;
            align-items: center;
            gap: 6px;
        }
        .filter-section-title::after {
            content: '';
            flex: 1;
            height: 1px;
            background: var(--lilac-soft);
        }
        .filter-item {
            display: flex;
            align-items: center;
            gap: 10px;
            padding: 10px 14px;
            border-radius: 12px;
            text-decoration: none;
            color: #554a6b;
            font-size: 13px;
            font-weight: 500;
            margin-bottom: 4px;
            transition: all 0.2s;
        }
        .filter-item:hover {
            background: var(--lilac-pale);
            color: var(--purple);
            transform: translateX(3px);
        }
        .filter-item.active {
            background: linear-gradient(135deg, var(--lilac-soft), #f3ecff);
            color: var(--purple);
            font-weight: 700;
            border-left: 3.5px solid var(--purple);
        }
        .filter-item .fi-dot {
            width: 7px; height: 7px;
            border-radius: 50%;
            background: currentColor;
            flex-shrink: 0;
            opacity: 0.5;
        }
        .filter-item.active .fi-dot { opacity: 1; }

        /* ===== AREA PRODUK (KANAN) ===== */
        .products-area { min-width: 0; }

        /* Toolbar */
        .products-toolbar {
            display: flex;
            align-items: center;
            gap: 16px;
            margin-bottom: 28px;
            flex-wrap: wrap;
        }
        .search-bar {
            flex: 1;
            min-width: 220px;
            position: relative;
        }
        .search-bar input {
            width: 100%;
            padding: 13px 20px 13px 46px;
            border: 1.5px solid rgba(221, 214, 254, 0.9);
            border-radius: 14px;
            font-family: 'Poppins', sans-serif;
            font-size: 13.5px;
            background: white;
            outline: none;
            color: var(--text);
            box-shadow: 0 2px 10px rgba(107, 33, 168, 0.03);
            transition: border-color 0.2s, box-shadow 0.2s;
        }
        .search-bar input:focus {
            border-color: var(--purple);
            box-shadow: 0 0 0 3px rgba(107, 33, 168, 0.12);
        }
        .search-bar-icon {
            position: absolute;
            left: 16px; top: 50%;
            transform: translateY(-50%);
            color: #7C3AED;
            pointer-events: none;
            font-size: 15px;
        }
        .toolbar-info {
            font-size: 13.5px;
            color: var(--text-muted);
            white-space: nowrap;
            font-weight: 500;
        }
        .toolbar-info strong { color: var(--purple); font-weight: 700; }

        /* ===== PRODUK GRID ===== */
        .products-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(240px, 1fr));
            gap: 24px;
        }

        /* ===== PRODUK CARD (LACTACYD STYLE LUXURY) ===== */
        .product-card {
            background: linear-gradient(160deg, #FFFFFF 0%, #FAF8FF 100%);
            border-radius: 22px;
            border: 1.5px solid #DDD6FE;
            box-shadow: 0 4px 18px rgba(109, 40, 217, 0.08);
            display: flex;
            flex-direction: column;
            text-decoration: none;
            overflow: hidden;
            transition: transform 0.3s cubic-bezier(0.34, 1.56, 0.64, 1),
                        box-shadow 0.3s ease,
                        border-color 0.25s;
            position: relative;
        }
        .product-card:hover {
            transform: translateY(-8px);
            box-shadow: 0 20px 48px rgba(107, 33, 168, 0.18);
            border-color: #8B5CF6;
        }

        /* Badge */
        .product-badge {
            position: absolute;
            top: 14px; left: 14px;
            background: linear-gradient(135deg, var(--purple) 0%, var(--purple-mid) 100%);
            color: white;
            padding: 4px 12px;
            border-radius: 999px;
            font-size: 10px;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 0.6px;
            z-index: 2;
            box-shadow: 0 4px 10px rgba(107, 33, 168, 0.25);
        }

        /* Gambar produk */
        .product-img-area {
            width: 100%;
            height: 280px;
            background: linear-gradient(145deg, #EDE9FE 0%, #DDD6FE 100%);
            display: flex;
            align-items: center;
            justify-content: center;
            overflow: hidden;
            position: relative;
        }
        .product-img-area::before {
            content: '';
            position: absolute;
            width: 160px; height: 160px;
            background: radial-gradient(circle, rgba(107,33,168,0.12) 0%, transparent 70%);
            border-radius: 50%;
        }
        .product-img-area img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            object-position: center;
            transition: transform 0.35s ease;
            position: relative;
            z-index: 1;
        }
        .product-card:hover .product-img-area img {
            transform: scale(1.06);
        }
        .product-img-placeholder {
            display: flex;
            flex-direction: column;
            align-items: center;
            gap: 8px;
            color: var(--purple);
            position: relative;
            z-index: 1;
        }

        /* Info produk */
        .product-info {
            padding: 20px 20px 22px;
            flex: 1;
            display: flex;
            flex-direction: column;
            border-top: 2px solid #DDD6FE;
            background: linear-gradient(180deg, #FAF8FF 0%, #FFFFFF 60%);
        }
        .product-category {
            font-size: 11px;
            font-weight: 700;
            color: #A855F7;
            text-transform: uppercase;
            letter-spacing: 1px;
            margin-bottom: 6px;
        }
        .product-name {
            font-family: 'Poppins', sans-serif;
            font-size: 16px;
            font-weight: 700;
            color: var(--text);
            line-height: 1.35;
            margin-bottom: 8px;
            flex: 1;
        }

        /* Tags */
        .product-tags-row {
            display: flex;
            flex-wrap: wrap;
            gap: 5px;
            margin-bottom: 12px;
        }
        .product-tag-pill {
            background: var(--lilac-pale);
            color: var(--purple);
            padding: 3px 9px;
            border-radius: 999px;
            font-size: 10.5px;
            font-weight: 600;
            border: 1px solid var(--lilac-border);
        }

        /* Price row */
        .product-price-row {
            display: flex;
            align-items: baseline;
            justify-content: space-between;
            margin-bottom: 14px;
        }
        .product-price {
            font-family: 'Poppins', sans-serif;
            font-size: 17px;
            font-weight: 800;
            color: var(--purple);
        }
        .product-rating-stars {
            font-size: 11.5px;
            color: #F59E0B;
            font-weight: 600;
        }

        /* Dual Action Buttons */
        .product-actions-wrap {
            display: flex;
            flex-direction: column;
            gap: 8px;
        }
        .btn-card-detail {
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 10px 16px;
            border: 1.5px solid #C4B5FD;
            border-radius: 10px;
            background: #F5F3FF;
            color: #6B21A8;
            font-size: 11.5px;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 0.8px;
            text-decoration: none;
            transition: all 0.2s;
        }
        .btn-card-detail:hover {
            border-color: var(--purple);
            color: var(--purple);
            background: #EDE9FE;
        }
        .btn-card-cart {
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 10px 16px;
            border: none;
            border-radius: 10px;
            background: linear-gradient(135deg, #8B5CF6, #7C3AED);
            color: white;
            font-size: 11.5px;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 0.8px;
            cursor: pointer;
            font-family: 'Poppins', sans-serif;
            transition: opacity 0.2s, transform 0.2s;
            width: 100%;
            box-shadow: 0 4px 14px rgba(124, 58, 237, 0.30);
        }
        .btn-card-cart:hover {
            opacity: 0.92;
            transform: translateY(-1px);
        }

        /* ===== MOBILE DRAWER ===== */
        .mobile-filter-bar {
            display: none;
            position: sticky;
            top: 60px;
            z-index: 100;
            background: white;
            border-bottom: 1px solid var(--lilac-soft);
            padding: 12px 16px;
            gap: 10px;
            box-shadow: 0 2px 10px rgba(107,33,168,0.07);
        }
        .filter-toggle-chip {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            background: white;
            border: 1.5px solid var(--lilac-border);
            color: var(--purple);
            padding: 8px 16px;
            border-radius: 999px;
            font-family: 'Poppins', sans-serif;
            font-size: 13px;
            font-weight: 600;
            cursor: pointer;
        }
        .filter-drawer-overlay {
            display: none;
            position: fixed;
            inset: 0;
            background: rgba(0,0,0,0.4);
            backdrop-filter: blur(3px);
            z-index: 998;
        }
        .filter-drawer {
            position: fixed;
            left: 0; top: 0;
            width: 80%; max-width: 320px;
            height: 100%;
            background: white;
            z-index: 999;
            transform: translateX(-100%);
            transition: transform 0.3s cubic-bezier(0.16, 1, 0.3, 1);
            overflow-y: auto;
            box-shadow: 4px 0 30px rgba(107,33,168,0.15);
        }
        .filter-drawer.open { transform: translateX(0); }
        .filter-drawer-overlay.open { display: block; }
        .filter-drawer-header {
            background: linear-gradient(135deg, var(--purple) 0%, var(--purple-mid) 100%);
            padding: 20px 22px;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        .filter-drawer-header h3 { color: white; font-size: 16px; font-weight: 700; }
        .close-drawer-btn {
            width: 32px; height: 32px;
            background: rgba(255,255,255,0.2);
            border: none;
            border-radius: 8px;
            color: white;
            font-size: 18px;
            cursor: pointer;
            display: flex; align-items: center; justify-content: center;
        }
        .filter-drawer-body { padding: 20px 22px; }

        @media (max-width: 1024px) {
            .shop-page { grid-template-columns: 240px 1fr; gap: 20px; }
            .shop-hero-title { font-size: 40px; }
        }
        @media (max-width: 768px) {
            .shop-hero-wrap { padding: 60px 18px 90px 18px; }
            .shop-hero-title { font-size: 32px; }
            .shop-page { grid-template-columns: 1fr; padding: 0 16px 60px; }
            .filter-panel { display: none; }
            .mobile-filter-bar { display: flex; }
            .products-grid { grid-template-columns: repeat(2, 1fr); gap: 14px; }
            .product-img-area { height: 200px; }
            .product-info { padding: 14px; }
            .product-name { font-size: 14px; }
            .product-price { font-size: 15px; }
        }
        @media (max-width: 480px) {
            .products-grid { grid-template-columns: 1fr; }
            .product-img-area { height: 260px; }
        }
    </style>
</head>
<body>

    @include('partials.navbar')

    <!-- Mobile Filter Bar -->
    <div class="mobile-filter-bar" id="mobileFilterBar">
        <button class="filter-toggle-chip" id="filterToggleBtn" onclick="openFilterDrawer()">
            <span>🔮</span> Filter Kategori
        </button>
        @if(request('category_id') || request('filter') || request('search'))
            <a href="{{ route('shop.index') }}" style="display:inline-flex;align-items:center;gap:5px;background:#FEF2F2;color:#DC2626;border:1.5px solid #FECACA;padding:8px 14px;border-radius:999px;font-size:12px;font-weight:600;text-decoration:none;">
                ✕ Reset
            </a>
        @endif
    </div>

    <!-- Filter Drawer (Mobile) -->
    <div class="filter-drawer-overlay" id="filterOverlay" onclick="closeFilterDrawer()"></div>
    <div class="filter-drawer" id="filterDrawer">
        <div class="filter-drawer-header">
            <h3>🔮 Filter Produk</h3>
            <button class="close-drawer-btn" onclick="closeFilterDrawer()">✕</button>
        </div>
        <div class="filter-drawer-body">
            <div class="filter-section">
                <div class="filter-section-title">Koleksi</div>
                <a href="{{ route('shop.index', ['filter' => 'new']) }}" class="filter-item {{ request('filter') == 'new' ? 'active' : '' }}">
                    <span class="fi-dot"></span> ✨ New Arrival
                </a>
                <a href="{{ route('shop.index', ['filter' => 'best']) }}" class="filter-item {{ request('filter') == 'best' ? 'active' : '' }}">
                    <span class="fi-dot"></span> 🔥 Best Seller
                </a>
                <a href="{{ route('shop.index') }}" class="filter-item {{ !request('filter') && !request('category_id') ? 'active' : '' }}">
                    <span class="fi-dot"></span> 🛍️ Semua Produk
                </a>
            </div>
            @if($categories->count() > 0)
            <div class="filter-section">
                <div class="filter-section-title">Kategori</div>
                @foreach($categories as $cat)
                    <a href="{{ route('shop.index', ['category_id' => $cat->id]) }}"
                       class="filter-item {{ request('category_id') == $cat->id ? 'active' : '' }}">
                        <span class="fi-dot"></span> {{ $cat->name }}
                    </a>
                @endforeach
            </div>
            @endif
        </div>
    </div>

    <!-- ===== 1. HERO HEADER BANNER ===== -->
    <div class="shop-hero-wrap">
        <div class="shop-hero-ambient"></div>
        <div class="shop-hero-content">
            <span class="shop-pill-tag">
                ✨ Official Clinical Catalog
            </span>
            <h1 class="shop-hero-title">
                Our Signature<br>
                <span>Collections</span>
            </h1>
            <p class="shop-hero-desc">
                Formulasi klinis premium yang dirancang khusus untuk memenuhi kebutuhan nutrisi, kelembapan, dan perlindungan setiap jenis kulit wanita Indonesia.
            </p>
        </div>
    </div>

    <!-- ===== PEMBATAS GELOMBANG ESTETIK ===== -->
    <div class="divider-wave-shop">
        <svg viewBox="0 0 1440 80" preserveAspectRatio="none">
            <path d="M0,0 C320,65 640,75 960,35 C1200,5 1360,25 1440,40 L1440,80 L0,80 Z" class="fill-white"></path>
        </svg>
    </div>

    <!-- ===== QUICK CATEGORY CHIPS ===== -->
    <div class="quick-chips-wrap">
        <a href="{{ route('shop.index') }}" class="chip-pill {{ !request('category_id') && !request('filter') ? 'active' : '' }}">
            🛍️ Semua Produk
        </a>
        <a href="{{ route('shop.index', ['filter' => 'new']) }}" class="chip-pill {{ request('filter') == 'new' ? 'active' : '' }}">
            ✨ New Arrival
        </a>
        <a href="{{ route('shop.index', ['filter' => 'best']) }}" class="chip-pill {{ request('filter') == 'best' ? 'active' : '' }}">
            🔥 Best Seller
        </a>
        @foreach($categories as $cat)
            <a href="{{ route('shop.index', ['category_id' => $cat->id]) }}" class="chip-pill {{ request('category_id') == $cat->id ? 'active' : '' }}">
                {{ $cat->name }}
            </a>
        @endforeach
    </div>

    <!-- ===== MAIN CONTENT LAYOUT ===== -->
    <div class="shop-page">

        <!-- ===== SIDEBAR FILTER (Desktop) ===== -->
        <aside class="filter-panel">
            <div class="filter-panel-header">
                <span>🔮</span>
                <h3>Filter Produk</h3>
            </div>
            <div class="filter-panel-body">

                <div class="filter-section">
                    <div class="filter-section-title">Koleksi Pilihan</div>
                    <a href="{{ route('shop.index', ['filter' => 'new']) }}"
                       class="filter-item {{ request('filter') == 'new' ? 'active' : '' }}">
                        <span class="fi-dot"></span> ✨ New Arrival
                    </a>
                    <a href="{{ route('shop.index', ['filter' => 'best']) }}"
                       class="filter-item {{ request('filter') == 'best' ? 'active' : '' }}">
                        <span class="fi-dot"></span> 🔥 Best Seller
                    </a>
                    <a href="{{ route('shop.index') }}"
                       class="filter-item {{ !request('filter') && !request('category_id') ? 'active' : '' }}">
                        <span class="fi-dot"></span> 🛍️ Semua Produk
                    </a>
                </div>

                @if($categories->count() > 0)
                <div class="filter-section">
                    <div class="filter-section-title">Kategori Perawatan</div>
                    @foreach($categories as $cat)
                        <a href="{{ route('shop.index', ['category_id' => $cat->id]) }}"
                           class="filter-item {{ request('category_id') == $cat->id ? 'active' : '' }}">
                            <span class="fi-dot"></span> {{ $cat->name }}
                        </a>
                    @endforeach
                </div>
                @endif

                @if(request('category_id') || request('filter') || request('search'))
                <div style="margin-top: 10px; padding-top: 18px; border-top: 1px solid var(--lilac-soft);">
                    <a href="{{ route('shop.index') }}" style="display: flex; align-items: center; justify-content: center; gap: 6px; background: #FEF2F2; color: #DC2626; border: 1.5px solid #FECACA; padding: 10px; border-radius: 12px; font-size: 12px; font-weight: 700; text-decoration: none; transition: background 0.2s;">
                        ✕ Reset Semua Filter
                    </a>
                </div>
                @endif

            </div>
        </aside>

        <!-- ===== AREA PRODUK (Kanan) ===== -->
        <div class="products-area">

            <!-- Toolbar Search -->
            <div class="products-toolbar">
                <div class="search-bar">
                    <span class="search-bar-icon">🔍</span>
                    <form action="{{ route('shop.index') }}" method="GET" style="display:contents;">
                        @if(request('category_id'))
                            <input type="hidden" name="category_id" value="{{ request('category_id') }}">
                        @endif
                        @if(request('filter'))
                            <input type="hidden" name="filter" value="{{ request('filter') }}">
                        @endif
                        <input type="text" name="search" value="{{ request('search') }}"
                               placeholder="Cari serum, moisturizer, sunscreen, cleanser...">
                    </form>
                </div>
                <div class="toolbar-info">
                    Menampilkan <strong>{{ $products->count() }}</strong> produk
                </div>
            </div>

            <!-- Produk Grid -->
            <div class="products-grid">
                @forelse($products as $product)
                    @php
                        $img = $product->images->where('is_primary', 1)->first() ?? $product->images->first();
                        $categoryName = $product->category->name ?? null;
                        $tags = [];
                        if ($categoryName) {
                            $tags[] = $categoryName;
                        }
                        if (stripos($product->name, 'serum') !== false) { $tags[] = 'Serum'; }
                        elseif (stripos($product->name, 'moisturizer') !== false || stripos($product->name, 'cream') !== false) { $tags[] = 'Moisturizer'; }
                        elseif (stripos($product->name, 'sunscreen') !== false || stripos($product->name, 'sun') !== false) { $tags[] = 'SPF Protection'; }
                        elseif (stripos($product->name, 'toner') !== false) { $tags[] = 'Hydrating'; }
                        elseif (stripos($product->name, 'cleanser') !== false || stripos($product->name, 'wash') !== false) { $tags[] = 'Deep Cleanse'; }
                        else { $tags[] = 'Clinical Care'; }
                        $tags = array_unique($tags);
                    @endphp

                    <div class="product-card">

                        <!-- Badge -->
                        <span class="product-badge">⭐ New</span>

                        <!-- Gambar -->
                        <div class="product-img-area">
                            @if($img && $img->image_path)
                                <img src="{{ asset('storage/' . $img->image_path) }}" alt="{{ $product->name }}" loading="lazy">
                            @else
                                <div class="product-img-placeholder">
                                    <span style="font-size: 32px;">🧴</span>
                                    <span>Gitania Skincare</span>
                                </div>
                            @endif
                        </div>

                        <!-- Info -->
                        <div class="product-info">
                            @if($categoryName)
                                <div class="product-category">{{ $categoryName }}</div>
                            @endif
                            <h3 class="product-name">{{ $product->name }}</h3>

                            <!-- Tags -->
                            <div class="product-tags-row">
                                @foreach(array_slice($tags, 0, 2) as $t)
                                    <span class="product-tag-pill">{{ $t }}</span>
                                @endforeach
                            </div>

                            <!-- Rating & Price -->
                            <div class="product-price-row">
                                <div class="product-price">Rp{{ number_format($product->price, 0, ',', '.') }}</div>
                                <div class="product-rating-stars">4.9 ★</div>
                            </div>

                            <!-- Dual Action Buttons -->
                            <div class="product-actions-wrap">
                                <a href="{{ route('products.show', $product->slug ?? $product->id) }}" class="btn-card-detail">
                                    SELENGKAPNYA <span>→</span>
                                </a>
                                <button class="btn-card-cart" onclick="addToCartShop({{ $product->id }}, this)">
                                    TAMBAH KE KERANJANG <span>→</span>
                                </button>
                            </div>
                        </div>

                    </div>
                @empty
                    <div style="grid-column: 1 / -1; text-align: center; padding: 80px 20px; background: #FAF8FF; border-radius: 26px; border: 1.5px solid rgba(221, 214, 254, 0.8);">
                        <span style="font-size: 48px; display: block; margin-bottom: 12px;">🔍</span>
                        <h3 style="font-family: 'Playfair Display', serif; font-size: 22px; font-weight: 600; color: var(--text); margin-bottom: 8px;">Produk Tidak Ditemukan</h3>
                        <p style="color: var(--text-muted); font-size: 14px; margin-bottom: 22px;">
                            Coba gunakan kata kunci lain atau reset filter kategori pencarian.
                        </p>
                        <a href="{{ route('shop.index') }}"
                           style="display: inline-flex; align-items: center; gap: 8px; background: var(--purple); color: white; padding: 12px 28px; border-radius: 999px; text-decoration: none; font-weight: 700; font-size: 13.5px; box-shadow: 0 4px 15px rgba(107,33,168,0.25);">
                            ← Lihat Semua Produk
                        </a>
                    </div>
                @endforelse
            </div>

        </div>
    </div>

    @include('partials.footer')
    @include('partials.chatbot')

    <script>
        function openFilterDrawer() {
            document.getElementById('filterDrawer').classList.add('open');
            document.getElementById('filterOverlay').classList.add('open');
            document.body.style.overflow = 'hidden';
        }
        function closeFilterDrawer() {
            document.getElementById('filterDrawer').classList.remove('open');
            document.getElementById('filterOverlay').classList.remove('open');
            document.body.style.overflow = '';
        }

        function addToCartShop(productId, btn) {
            const originalText = btn.innerHTML;
            btn.innerHTML = 'Menambahkan... <span>⏳</span>';
            btn.disabled = true;

            const fd = new FormData();
            fd.append('product_id', productId);
            fd.append('quantity', 1);
            fd.append('_token', '{{ csrf_token() }}');

            fetch("{{ route('cart.add') }}", { method: 'POST', body: fd })
                .then(r => r.json())
                .then(data => {
                    btn.innerHTML = 'Ditambahkan! ✓ <span>🛒</span>';
                    btn.style.background = '#16A34A';
                    btn.style.borderColor = '#16A34A';
                    setTimeout(() => {
                        btn.innerHTML = originalText;
                        btn.style.background = '';
                        btn.style.borderColor = '';
                        btn.disabled = false;
                        if (typeof toggleCart === 'function') toggleCart();
                    }, 1600);
                })
                .catch(() => {
                    btn.innerHTML = originalText;
                    btn.disabled = false;
                });
        }
    </script>
</body>
</html>
