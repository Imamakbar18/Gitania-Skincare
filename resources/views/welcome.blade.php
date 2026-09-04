@extends('layouts.app')

@section('title', 'Gitania Skincare — Clinical Care for Your Skin')

@section('content')
<style>
    /* ===================================================
       HERO BANNER — SEAMLESS STUDIO BLEND & INTERACTIVE SLIDER
    =================================================== */
    .lactacyd-hero-banner-wrapper {
        position: relative;
        width: 100%;
        min-height: 520px;
        background: linear-gradient(135deg, #EAE4F5 0%, #DDD4EC 45%, #D6CAEA 100%);
        overflow: hidden;
        display: flex;
        align-items: center;
        padding-bottom: 50px;
    }

    /* Background Ambient Lighting */
    .hero-studio-glow {
        position: absolute;
        top: -80px;
        right: 25%;
        width: 450px;
        height: 450px;
        background: radial-gradient(circle, rgba(255, 255, 255, 0.45) 0%, transparent 70%);
        border-radius: 50%;
        pointer-events: none;
    }

    /* Inner Flex Container - Left Text & Right Interactive Image Slider */
    .lactacyd-hero-content-flex {
        width: 100%;
        max-width: 1440px;
        margin: 0 auto;
        padding: 40px 40px 60px 60px;
        position: relative;
        z-index: 3;
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 30px;
    }

    /* Left Text Box */
    .lactacyd-hero-textbox {
        max-width: 440px;
        flex-shrink: 0;
    }

    /* Judul Serif Mewah Sesuai Referensi */
    .lactacyd-hero-title {
        font-family: 'Playfair Display', serif;
        font-size: 52px;
        font-weight: 500;
        color: #1a162b;
        line-height: 1.12;
        margin: 0 0 16px 0;
        letter-spacing: -0.5px;
    }

    /* Subtitle Sesuai Referensi */
    .lactacyd-hero-subtitle {
        font-family: 'Poppins', sans-serif;
        font-size: 14px;
        color: #4a4058;
        line-height: 1.75;
        margin: 0;
        font-weight: 400;
    }

    /* ===================================================
       INTERACTIVE DUAL-IMAGE SLIDER / HOVER-SWITCH
    =================================================== */
    .lactacyd-hero-image-holder {
        flex: 1;
        display: flex;
        flex-direction: column;
        align-items: flex-end;
        max-width: 820px;
        position: relative;
    }

    .hero-slider-frame {
        position: relative;
        width: 100%;
        max-width: 780px;
        border-radius: 22px;
        overflow: hidden;
        background: #ffffff;
        box-shadow: 0 16px 45px rgba(90, 46, 136, 0.14);
        border: 3.5px solid rgba(255, 255, 255, 0.95);
        cursor: pointer;
        transition: transform 0.3s ease, box-shadow 0.3s ease;
    }
    .hero-slider-frame:hover {
        transform: translateY(-4px);
        box-shadow: 0 22px 55px rgba(90, 46, 136, 0.22);
    }

    /* Slides Container */
    .hero-slides-wrapper {
        position: relative;
        width: 100%;
        height: 440px;
    }

    .hero-slide-item {
        position: absolute;
        inset: 0;
        width: 100%;
        height: 100%;
        opacity: 0;
        visibility: hidden;
        transform: scale(1.03);
        transition: opacity 0.65s cubic-bezier(0.4, 0, 0.2, 1), transform 0.65s cubic-bezier(0.4, 0, 0.2, 1), visibility 0.65s;
    }
    .hero-slide-item.active {
        opacity: 1;
        visibility: visible;
        transform: scale(1);
    }
    .hero-slide-item img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        display: block;
    }



    /* Slide Controls (Minimalist Interactive Pills) */
    .hero-slide-pills {
        display: flex;
        gap: 8px;
        margin-top: 14px;
        z-index: 5;
    }
    .hero-pill-btn {
        background: rgba(255, 255, 255, 0.7);
        border: 1.5px solid rgba(221, 214, 254, 0.9);
        color: #4a4058;
        padding: 5px 14px;
        border-radius: 999px;
        font-size: 11px;
        font-weight: 600;
        cursor: pointer;
        transition: all 0.25s ease;
        display: flex;
        align-items: center;
        gap: 6px;
    }
    .hero-pill-btn:hover {
        background: white;
        color: var(--primary);
        border-color: var(--primary);
    }
    .hero-pill-btn.active {
        background: var(--primary);
        color: white;
        border-color: var(--primary);
        box-shadow: 0 3px 10px rgba(107, 33, 168, 0.25);
    }

    /* Lengkungan Busur Putih di Bagian Bawah (Lactacyd Bottom Arc) */
    .lactacyd-bottom-arch {
        position: absolute;
        bottom: -1px;
        left: 0;
        width: 100%;
        overflow: hidden;
        line-height: 0;
        z-index: 4;
        pointer-events: none;
    }
    .lactacyd-bottom-arch svg {
        position: relative;
        display: block;
        width: calc(100% + 1.3px);
        height: 60px;
    }
    .lactacyd-bottom-arch .shape-fill {
        fill: var(--bg, #FAFAFA);
    }





    /* ===================================================
       PRODUCTS SECTION — LACTACYD-STYLE CARDS
    =================================================== */
    .products-section {
        max-width: 1320px;
        margin: 50px auto 0 auto;
        padding: 0 24px 80px 24px;
    }
    .products-header {
        display: flex;
        justify-content: space-between;
        align-items: flex-end;
        margin-bottom: 32px;
        flex-wrap: wrap;
        gap: 12px;
    }
    .products-title {
        font-size: 30px;
        font-weight: 800;
        color: var(--text-dark);
        margin: 0 0 4px 0;
        font-family: 'Poppins', sans-serif;
    }
    .products-subtitle {
        color: var(--text-muted);
        font-size: 13px;
        margin: 0;
    }

    /* === DESKTOP GRID === */
    .product-grid {
        display: grid;
        grid-template-columns: repeat(4, 1fr);
        gap: 22px;
    }

    /* === PRODUCT CARD === */
    .product-card {
        background: white;
        border-radius: 22px;
        border: 1px solid var(--primary-soft);
        box-shadow: 0 4px 18px rgba(107, 33, 168, 0.05);
        display: flex;
        flex-direction: column;
        text-decoration: none;
        overflow: hidden;
        transition: transform 0.28s cubic-bezier(0.34, 1.56, 0.64, 1), box-shadow 0.28s ease;
        position: relative;
    }
    .product-card:hover {
        transform: translateY(-8px);
        box-shadow: 0 20px 48px rgba(107, 33, 168, 0.14);
    }

    /* Badge */
    .product-new-badge {
        position: absolute;
        top: 16px; left: 16px;
        display: flex;
        align-items: center;
        gap: 5px;
        background: linear-gradient(135deg, #6B21A8, #7C3AED);
        color: white;
        padding: 5px 12px;
        border-radius: 999px;
        font-size: 10px;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 0.6px;
        z-index: 2;
    }

    /* Gambar Produk */
    .product-img-wrap {
        width: 100%;
        height: 220px;
        background: linear-gradient(145deg, #F5F3FF 0%, #EDE9FE 100%);
        overflow: hidden;
        position: relative;
    }
    .product-img-wrap::before {
        display: none;
    }
    .product-img-wrap img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        object-position: center;
        position: relative;
        z-index: 1;
        transition: transform 0.35s ease;
    }
    .product-card:hover .product-img-wrap img {
        transform: scale(1.06);
    }
    .product-img-placeholder {
        font-size: 13px;
        color: var(--primary);
        font-weight: 600;
        text-align: center;
        padding: 16px;
        position: relative;
        z-index: 1;
    }

    /* Body kartu */
    .product-body {
        padding: 20px 22px 22px;
        display: flex;
        flex-direction: column;
        flex: 1;
        border-top: 1px solid var(--primary-soft);
    }
    .product-category-label {
        font-size: 11px;
        font-weight: 700;
        color: #A855F7;
        text-transform: uppercase;
        letter-spacing: 1px;
        margin-bottom: 6px;
    }
    .product-name {
        font-size: 18px;
        font-weight: 800;
        color: var(--text-dark);
        margin: 0 0 8px 0;
        line-height: 1.3;
        font-family: 'Poppins', sans-serif;
    }

    /* Tags */
    .product-tags {
        display: flex;
        flex-wrap: wrap;
        gap: 6px;
        margin-bottom: 12px;
    }
    .product-tag {
        background: var(--primary-pale);
        color: var(--primary);
        padding: 4px 11px;
        border-radius: 999px;
        font-size: 11px;
        font-weight: 600;
        border: 1px solid var(--primary-border);
    }

    /* Deskripsi */
    .product-desc {
        font-size: 13px;
        color: var(--text-muted);
        line-height: 1.65;
        margin-bottom: 18px;
        display: -webkit-box;
        -webkit-line-clamp: 2;
        -webkit-box-orient: vertical;
        overflow: hidden;
        flex: 1;
    }

    /* Harga */
    .product-price {
        font-size: 17px;
        font-weight: 800;
        color: var(--primary);
        margin-bottom: 14px;
        font-family: 'Poppins', sans-serif;
    }

    /* Tombol aksi */
    .product-actions {
        display: flex;
        flex-direction: column;
        gap: 8px;
    }
    .product-btn-detail {
        display: flex;
        align-items: center;
        justify-content: space-between;
        padding: 11px 18px;
        border: 2px solid var(--primary-border);
        border-radius: 10px;
        background: white;
        color: var(--text-dark);
        font-size: 12px;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 0.8px;
        text-decoration: none;
        cursor: pointer;
        transition: border-color 0.2s, color 0.2s;
    }
    .product-btn-detail:hover {
        border-color: var(--primary);
        color: var(--primary);
    }
    .product-btn-cart {
        display: flex;
        align-items: center;
        justify-content: space-between;
        padding: 11px 18px;
        border: 2px solid var(--primary);
        border-radius: 10px;
        background: var(--primary);
        color: white;
        font-size: 12px;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 0.8px;
        cursor: pointer;
        font-family: 'Poppins', sans-serif;
        transition: background 0.2s, border-color 0.2s;
        width: 100%;
    }
    .product-btn-cart:hover {
        background: var(--primary-dark);
        border-color: var(--primary-dark);
    }

    /* ===================================================
       MOBILE: HORIZONTAL SWIPE CAROUSEL
    =================================================== */
    .product-carousel-wrapper {
        display: none;
        position: relative;
    }
    .product-carousel {
        display: flex;
        gap: 16px;
        overflow-x: auto;
        scroll-snap-type: x mandatory;
        -webkit-overflow-scrolling: touch;
        padding-bottom: 16px;
        scrollbar-width: none;
        -ms-overflow-style: none;
    }
    .product-carousel::-webkit-scrollbar { display: none; }
    .product-carousel .product-card {
        flex: 0 0 82vw;
        max-width: 320px;
        scroll-snap-align: start;
    }
    .carousel-fade-right {
        position: absolute;
        top: 0; right: 0;
        width: 60px;
        height: calc(100% - 16px);
        background: linear-gradient(to left, rgba(250,250,250,0.9), transparent);
        pointer-events: none;
    }
    .carousel-dots {
        display: flex;
        justify-content: center;
        gap: 6px;
        margin-top: 12px;
    }
    .carousel-dot {
        width: 6px; height: 6px;
        border-radius: 50%;
        background: var(--primary-border);
        transition: background 0.2s, width 0.2s;
    }
    .carousel-dot.active {
        background: var(--primary);
        width: 20px;
        border-radius: 4px;
    }

    /* ===================================================
       RESPONSIVE BREAKPOINTS
    =================================================== */
    @media (max-width: 1200px) {
        .lactacyd-hero-title { font-size: 42px; }
        .hero-slides-wrapper { height: 380px; }
        .product-grid { grid-template-columns: repeat(3, 1fr); }
    }
    @media (max-width: 992px) {
        .lactacyd-hero-content-flex {
            flex-direction: column;
            text-align: center;
            padding: 30px 20px 60px 20px;
        }
        .lactacyd-hero-textbox {
            max-width: 100%;
        }
        .lactacyd-hero-image-holder {
            align-items: center;
            justify-content: center;
            max-width: 100%;
        }
        .hero-slides-wrapper {
            height: 320px;
        }
        .hero-slide-pills {
            justify-content: center;
        }
        .lactacyd-hero-title { font-size: 38px; }
        .product-grid { grid-template-columns: repeat(2, 1fr); }
    }
    @media (max-width: 640px) {
        .hero-slides-wrapper { height: 260px; }
        .lactacyd-hero-title { font-size: 30px; }
        .product-grid { display: none !important; }
        .product-carousel-wrapper { display: block; }
        .products-section { padding: 0 16px 60px 16px; }
    }
    @media (max-width: 480px) {
        .hero-slides-wrapper { height: 210px; }
        .lactacyd-hero-title { font-size: 26px; }
        .product-carousel .product-card { flex: 0 0 85vw; }
    }

    /* ===== PEMBATAS GELOMBANG UNGU LILAC HOMEPAGE ===== */
    .divider-organic-wrap {
        position: relative;
        line-height: 0;
        overflow: hidden;
        z-index: 2;
    }
    .divider-organic-svg {
        display: block;
        width: 100%;
        height: 75px;
    }
    .divider-reverse-wrap {
        position: relative;
        line-height: 0;
        overflow: hidden;
        z-index: 2;
    }
    .divider-reverse-svg {
        display: block;
        width: 100%;
        height: 65px;
    }

    /* ===================================================
       BEFORE & AFTER SECTION — LILAC THEME (REFERENSI FOTO 1)
    =================================================== */
    .before-after-wrapper-full {
        width: 100%;
        background: #F8F4FE;
        padding: 50px 0 60px 0;
        position: relative;
    }
    .before-after-section {
        max-width: 1320px;
        margin: 0 auto;
        padding: 0 24px;
    }
    .ba-header {
        text-align: center;
        max-width: 800px;
        margin: 0 auto 44px auto;
    }
    .ba-sub-kicker {
        display: block;
        color: #C084FC;
        font-size: 13px;
        font-weight: 700;
        letter-spacing: 2.5px;
        text-transform: uppercase;
        margin-bottom: 8px;
    }
    .ba-title {
        font-family: 'Poppins', sans-serif;
        font-size: 26px;
        font-weight: 700;
        color: #2D1B4E;
        letter-spacing: 0.8px;
        margin: 0;
        line-height: 1.4;
        text-transform: uppercase;
    }
    .ba-grid {
        display: grid;
        grid-template-columns: repeat(3, 1fr);
        gap: 26px;
        align-items: stretch;
    }
    .ba-card {
        background: #ffffff;
        border-radius: 22px;
        border: 1.5px solid rgba(216, 196, 248, 0.7);
        box-shadow: 0 10px 30px rgba(107, 33, 168, 0.08);
        overflow: hidden;
        display: flex;
        flex-direction: column;
        transition: transform 0.3s cubic-bezier(0.2, 0.8, 0.2, 1), box-shadow 0.3s ease;
    }
    .ba-card:hover {
        transform: translateY(-8px);
        box-shadow: 0 20px 48px rgba(107, 33, 168, 0.16);
    }
    .ba-top-banner {
        background: linear-gradient(165deg, #EFE5FD 0%, #DFC9FA 45%, #D0B1F8 100%);
        padding: 20px 18px 16px 18px;
        border-bottom: 1px solid rgba(221, 214, 254, 0.6);
        display: flex;
        flex-direction: column;
        align-items: center;
        position: relative;
    }
    .ba-clinic-watermark {
        position: absolute;
        top: 14px;
        left: 18px;
        display: flex;
        flex-direction: column;
        line-height: 1.1;
    }
    .ba-clinic-watermark .brand-name {
        font-family: 'Playfair Display', Georgia, serif;
        font-size: 16px;
        font-weight: 700;
        color: #7C3AED;
        letter-spacing: 0.5px;
    }
    .ba-clinic-watermark .brand-sub {
        font-size: 8px;
        font-weight: 700;
        color: #8B5CF6;
        letter-spacing: 1.2px;
        text-transform: uppercase;
    }
    .ba-pill-title {
        background: linear-gradient(180deg, #F8F3FF 0%, #EBDCFE 50%, #D8BEFA 100%);
        color: #4A1E70;
        font-size: 13.5px;
        font-weight: 700;
        padding: 5px 24px;
        border-radius: 999px;
        margin-top: 12px;
        margin-bottom: 16px;
        box-shadow: 0 4px 12px rgba(124, 58, 237, 0.16);
        letter-spacing: 0.3px;
        border: 1.5px solid rgba(255, 255, 255, 0.9);
        text-align: center;
    }
    .ba-photo-wrapper {
        position: relative;
        width: 100%;
        border-radius: 16px;
        overflow: hidden;
        background: #ffffff;
        box-shadow: 0 6px 20px rgba(90, 46, 136, 0.12);
        border: 2.5px solid rgba(255, 255, 255, 0.95);
        aspect-ratio: 4 / 3;
    }
    .ba-photo-img {
        width: 100%;
        height: 100%;
        display: block;
        object-fit: cover;
    }
    .ba-censor-left {
        position: absolute;
        top: 38%;
        left: 8%;
        width: 34%;
        height: 18px;
        background: #ffffff;
        border-radius: 6px;
        box-shadow: 0 2px 6px rgba(0, 0, 0, 0.18);
        pointer-events: none;
        z-index: 5;
    }
    .ba-censor-right {
        position: absolute;
        top: 38%;
        right: 8%;
        width: 34%;
        height: 18px;
        background: #ffffff;
        border-radius: 6px;
        box-shadow: 0 2px 6px rgba(0, 0, 0, 0.18);
        pointer-events: none;
        z-index: 5;
    }
    .ba-pill-before {
        position: absolute;
        bottom: 8px;
        left: 25%;
        transform: translateX(-50%);
        font-family: 'Playfair Display', Georgia, serif;
        font-style: italic;
        background: rgba(255, 255, 255, 0.92);
        backdrop-filter: blur(4px);
        color: #7A698F;
        font-size: 13px;
        padding: 2px 18px;
        border-radius: 999px;
        font-weight: 500;
        z-index: 5;
        box-shadow: 0 2px 6px rgba(0, 0, 0, 0.1);
    }
    .ba-pill-after {
        position: absolute;
        bottom: 8px;
        right: 25%;
        transform: translateX(50%);
        font-family: 'Playfair Display', Georgia, serif;
        font-style: italic;
        background: rgba(255, 255, 255, 0.92);
        backdrop-filter: blur(4px);
        color: #7A698F;
        font-size: 13px;
        padding: 2px 18px;
        border-radius: 999px;
        font-weight: 500;
        z-index: 5;
        box-shadow: 0 2px 6px rgba(0, 0, 0, 0.1);
    }
    .ba-tag-sub {
        display: flex;
        justify-content: space-between;
        align-items: center;
        width: 100%;
        margin-top: 12px;
        font-size: 11.5px;
        color: #4C1D95;
        font-weight: 600;
    }
    .ba-tag-sub .hashtag {
        font-size: 9.5px;
        color: #7C3AED;
        font-weight: 800;
        letter-spacing: 0.5px;
        text-transform: uppercase;
    }
    .ba-desc-box {
        padding: 22px 20px 26px 20px;
        font-size: 13px;
        color: #374151;
        line-height: 1.7;
        flex: 1;
        display: flex;
        align-items: flex-start;
        background: #ffffff;
    }
    .ba-desc-box p {
        margin: 0;
    }

    /* ===================================================
       REVIEWS / TESTIMONIALS SECTION — LILAC THEME (REFERENSI FOTO 2)
    =================================================== */
    .reviews-wrapper-full {
        width: 100%;
        background: linear-gradient(180deg, #EDE5FA 0%, #F8F5FE 50%, #EDE5FA 100%);
        padding: 50px 0 70px 0;
        position: relative;
        overflow: hidden;
    }
    .reviews-container {
        max-width: 1320px;
        margin: 0 auto;
        padding: 0 24px;
        position: relative;
    }
    .reviews-header {
        display: flex;
        justify-content: space-between;
        align-items: flex-end;
        margin-bottom: 36px;
        gap: 20px;
        flex-wrap: wrap;
    }
    .reviews-tag-badge {
        font-size: 12px;
        font-weight: 700;
        color: #7C3AED;
        text-transform: uppercase;
        letter-spacing: 2px;
        margin-bottom: 8px;
    }
    .reviews-title {
        font-family: 'Poppins', sans-serif;
        font-size: 24px;
        font-weight: 800;
        color: #2D1B4E;
        max-width: 820px;
        line-height: 1.35;
        text-transform: uppercase;
        margin: 0;
    }
    .reviews-nav-btns {
        display: flex;
        gap: 12px;
    }
    .reviews-nav-btn {
        width: 44px;
        height: 44px;
        border-radius: 50%;
        background: white;
        border: 1.5px solid #DDD6FE;
        color: #6B21A8;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 18px;
        cursor: pointer;
        transition: all 0.25s ease;
        box-shadow: 0 4px 12px rgba(107, 33, 168, 0.08);
    }
    .reviews-nav-btn:hover {
        background: #6B21A8;
        color: white;
        border-color: #6B21A8;
        transform: scale(1.06);
    }

    .reviews-slider-track {
        display: flex;
        gap: 22px;
        overflow-x: auto;
        scroll-snap-type: x mandatory;
        padding: 10px 4px 20px 4px;
        scrollbar-width: none;
        -ms-overflow-style: none;
        scroll-behavior: smooth;
    }
    .reviews-slider-track::-webkit-scrollbar {
        display: none;
    }
    .review-card {
        flex: 0 0 380px;
        background: #ffffff;
        border-radius: 20px;
        padding: 26px 26px 24px 26px;
        border: 1.5px solid rgba(221, 214, 254, 0.7);
        box-shadow: 0 10px 30px rgba(107, 33, 168, 0.06);
        scroll-snap-align: start;
        display: flex;
        flex-direction: column;
        justify-content: space-between;
        transition: transform 0.28s ease, box-shadow 0.28s ease;
    }
    .review-card:hover {
        transform: translateY(-6px);
        box-shadow: 0 16px 40px rgba(107, 33, 168, 0.12);
    }
    .review-top-meta {
        display: flex;
        justify-content: space-between;
        align-items: flex-start;
        margin-bottom: 16px;
    }
    .review-user-info {
        display: flex;
        align-items: center;
        gap: 12px;
    }
    .review-avatar {
        width: 44px;
        height: 44px;
        border-radius: 50%;
        background: linear-gradient(135deg, #6B21A8, #8B5CF6);
        color: white;
        display: flex;
        align-items: center;
        justify-content: center;
        font-weight: 700;
        font-size: 17px;
        box-shadow: 0 4px 10px rgba(107, 33, 168, 0.25);
    }
    .review-name {
        font-size: 15px;
        font-weight: 700;
        color: #1E1B4B;
        margin-bottom: 2px;
    }
    .review-verified {
        font-size: 11px;
        color: #059669;
        font-weight: 600;
        display: flex;
        align-items: center;
        gap: 3px;
    }
    .review-stars {
        color: #F59E0B;
        font-size: 15px;
        letter-spacing: 2px;
    }
    .review-text {
        font-size: 13.5px;
        color: #4B5563;
        line-height: 1.7;
        margin-bottom: 18px;
        flex: 1;
    }
    .review-product-tag {
        display: inline-block;
        background: #F3E8FF;
        color: #6B21A8;
        padding: 4px 12px;
        border-radius: 999px;
        font-size: 11px;
        font-weight: 600;
        border: 1px solid #DDD6FE;
        align-self: flex-start;
    }

    @media (max-width: 992px) {
        .ba-grid { grid-template-columns: repeat(2, 1fr); }
        .ba-title { font-size: 22px; }
        .reviews-title { font-size: 20px; }
        .review-card { flex: 0 0 320px; }
    }
    @media (max-width: 640px) {
        .ba-grid { grid-template-columns: 1fr; }
        .ba-title { font-size: 18px; }
        .reviews-title { font-size: 17px; }
        .review-card { flex: 0 0 85vw; }
        .before-after-section { padding: 30px 16px 60px 16px; }
        .reviews-wrapper-full { padding: 50px 0 60px 0; }
    }
</style>

<!-- ===== HERO BANNER SECTION (INTERACTIVE HOVER-SLIDE & LACTACYD ARCH) ===== -->
<div class="lactacyd-hero-banner-wrapper">

    <div class="hero-studio-glow"></div>

    <!-- Konten Flex: Teks Kiri & Slider Foto Interaktif di Kanan -->
    <div class="lactacyd-hero-content-flex">

        <!-- 1. Teks Minimalis Elegan (Sesuai Referensi Lactacyd) -->
        <div class="lactacyd-hero-textbox">
            <h1 class="lactacyd-hero-title">
                A product for<br>
                every skin
            </h1>
            <p class="lactacyd-hero-subtitle" id="heroSubtitleText">
                Apa pun jenis kulitmu, selalu ada produk Gitania Skincare yang membantu menjaga dan menampilkan versi terbaik kulitmu dari dalam.
            </p>
        </div>

        <!-- 2. Interactive Photo Slider Frame (Hover & Auto-Slide) -->
        <div class="lactacyd-hero-image-holder">
            
            <div class="hero-slider-frame" id="heroSliderFrame">
                <!-- Slides Wrapper -->
                <div class="hero-slides-wrapper">
                    @php
                        $heroBanners = (isset($banners) && $banners->count() > 0) 
                            ? $banners 
                            : \App\Models\Banner::where('is_active', true)->orderBy('order', 'asc')->get();
                    @endphp

                    @forelse($heroBanners as $idx => $b)
                        @php
                            $bSrc = str_starts_with($b->image_path, 'images/') 
                                ? asset($b->image_path) 
                                : asset('storage/' . $b->image_path);
                        @endphp
                        <div class="hero-slide-item {{ $idx === 0 ? 'active' : '' }}" data-index="{{ $idx }}">
                            <img src="{{ $bSrc }}" alt="{{ $b->title ?? 'Gitania Skincare' }}" loading="{{ $idx === 0 ? 'eager' : 'lazy' }}">
                        </div>
                    @empty
                        <div class="hero-slide-item active" data-index="0">
                            <img src="{{ asset('images/gitania-hero-banner.jpg') }}" alt="Gitania Skincare" loading="eager">
                        </div>
                    @endforelse
                </div>
            </div>

            <!-- Slide Navigation Pills -->
            @if(isset($heroBanners) && $heroBanners->count() > 1)
            <div class="hero-slide-pills">
                @foreach($heroBanners as $idx => $b)
                <button class="hero-pill-btn {{ $idx === 0 ? 'active' : '' }}" onclick="switchHeroSlide({{ $idx }})" data-index="{{ $idx }}">
                    <span>{{ $b->icon ?? '✨' }}</span> {{ $b->title ?? ('Slide ' . ($idx + 1)) }}
                </button>
                @endforeach
            </div>
            @endif

        </div>

    </div>

    <!-- 3. Lengkungan Busur Bawah Banner (Lactacyd Bottom Arc) -->
    <div class="lactacyd-bottom-arch">
        <svg viewBox="0 0 1440 120" preserveAspectRatio="none">
            <path d="M0,0 C480,100 960,100 1440,0 L1440,120 L0,120 Z" class="shape-fill"></path>
        </svg>
    </div>

</div>

<!-- ===== KATALOG PRODUK ===== -->
<div class="products-section" id="katalog-produk">
    <div class="products-header">
        <div>
            <h2 class="products-title">Our Products</h2>
            <p class="products-subtitle">{{ $products->count() }} produk tersedia untuk Anda</p>
        </div>
        <a href="{{ route('shop.index') }}" class="btn-outline" style="padding: 10px 22px; border-radius: 10px; font-size: 13px;">
            Lihat Semua →
        </a>
    </div>

    {{-- ===== DESKTOP: GRID ===== --}}
    <div class="product-grid">
        @forelse($products as $product)
            @php
                $img = $product->images->where('is_primary', 1)->first() ?? $product->images->first();
                $categoryName = $product->category->name ?? null;
                $tags = [];
                if ($categoryName) {
                    $tags[] = $categoryName;
                }
                if (stripos($product->name, 'serum') !== false) { $tags[] = 'Serum'; $tags[] = 'Brightening'; }
                elseif (stripos($product->name, 'moisturizer') !== false || stripos($product->name, 'cream') !== false) { $tags[] = 'Moisturizing'; $tags[] = 'Nourishing'; }
                elseif (stripos($product->name, 'sunscreen') !== false || stripos($product->name, 'sun') !== false) { $tags[] = 'SPF'; $tags[] = 'Protection'; }
                elseif (stripos($product->name, 'toner') !== false) { $tags[] = 'Hydrating'; $tags[] = 'pH Balance'; }
                elseif (stripos($product->name, 'wash') !== false || stripos($product->name, 'cleanser') !== false) { $tags[] = 'Cleansing'; $tags[] = 'Fresh'; }
                else { $tags[] = 'Skincare'; $tags[] = 'Premium'; }
                $tags = array_unique($tags);
                $hasDesc = isset($product->description) && $product->description;
            @endphp

            <div class="product-card">
                {{-- Badge --}}
                <div class="product-new-badge">⭐ New Product</div>

                {{-- Gambar Produk --}}
                <div class="product-img-wrap">
                    @if($img && $img->image_path)
                        <img src="{{ asset('storage/' . $img->image_path) }}" alt="{{ $product->name }}" loading="lazy">
                    @else
                        <div class="product-img-placeholder">{{ $product->name }}</div>
                    @endif
                </div>

                {{-- Body --}}
                <div class="product-body">
                    @if($categoryName)
                        <div class="product-category-label">{{ $categoryName }}</div>
                    @endif
                    <h3 class="product-name">{{ $product->name }}</h3>

                    {{-- Tags --}}
                    <div class="product-tags">
                        @foreach(array_slice($tags, 0, 3) as $tag)
                            <span class="product-tag">{{ $tag }}</span>
                        @endforeach
                    </div>

                    {{-- Deskripsi --}}
                    <p class="product-desc">
                        @if($hasDesc)
                            {{ $product->description }}
                        @else
                            Formulasi klinis premium untuk kulit sehat, lembap, dan bercahaya sepanjang hari.
                        @endif
                    </p>

                    {{-- Harga --}}
                    <div class="product-price">Rp{{ number_format($product->price, 0, ',', '.') }}</div>

                    {{-- Tombol Aksi --}}
                    <div class="product-actions">
                        <a href="{{ route('products.show', $product->slug ?? $product->id) }}" class="product-btn-detail">
                            SELENGKAPNYA
                            <span>→</span>
                        </a>
                        <button
                            class="product-btn-cart"
                            onclick="addToCartHome({{ $product->id }}, this)"
                        >
                            TAMBAH KE KERANJANG
                            <span>→</span>
                        </button>
                    </div>
                </div>
            </div>
        @empty
            <div style="grid-column: 1 / -1; text-align: center; padding: 60px 20px; color: var(--text-muted);">
                <div style="font-size: 48px; margin-bottom: 12px;">🔍</div>
                <p style="font-size: 15px; font-weight: 500;">Produk tidak ditemukan.</p>
                <a href="{{ route('home') }}" style="color: var(--primary); font-weight: 600;">Reset pencarian</a>
            </div>
        @endforelse
    </div>

    {{-- ===== MOBILE: HORIZONTAL CAROUSEL (SWIPE) ===== --}}
    <div class="product-carousel-wrapper">
        <div class="product-carousel" id="productCarousel">
            @forelse($products as $product)
                @php
                    $img = $product->images->where('is_primary', 1)->first() ?? $product->images->first();
                    $categoryName = $product->category->name ?? null;
                    $hasDesc = isset($product->description) && $product->description;
                @endphp
                <div class="product-card">
                    <div class="product-new-badge">⭐ New Product</div>
                    <div class="product-img-wrap">
                        @if($img && $img->image_path)
                            <img src="{{ asset('storage/' . $img->image_path) }}" alt="{{ $product->name }}" loading="lazy">
                        @else
                            <div class="product-img-placeholder">{{ $product->name }}</div>
                        @endif
                    </div>
                    <div class="product-body">
                        @if($categoryName)
                            <div class="product-category-label">{{ $categoryName }}</div>
                        @endif
                        <h3 class="product-name">{{ $product->name }}</h3>
                        <div class="product-tags">
                            <span class="product-tag">Skincare</span>
                            <span class="product-tag">Premium</span>
                        </div>
                        <p class="product-desc">
                            @if($hasDesc)
                                {{ $product->description }}
                            @else
                                Formulasi klinis premium untuk kulit sehat dan bercahaya.
                            @endif
                        </p>
                        <div class="product-price">Rp{{ number_format($product->price, 0, ',', '.') }}</div>
                        <div class="product-actions">
                            <a href="{{ route('products.show', $product->slug ?? $product->id) }}" class="product-btn-detail">
                                SELENGKAPNYA <span>→</span>
                            </a>
                            <button class="product-btn-cart" onclick="addToCartHome({{ $product->id }}, this)">
                                TAMBAH KE KERANJANG <span>→</span>
                            </button>
                        </div>
                    </div>
                </div>
            @empty
                <div style="padding: 40px; text-align: center; color: var(--text-muted);">Belum ada produk.</div>
            @endforelse
        </div>
        <div class="carousel-fade-right"></div>

        {{-- Dots Indicator --}}
        <div class="carousel-dots" id="carouselDots">
            @foreach($products as $i => $p)
                <div class="carousel-dot {{ $i === 0 ? 'active' : '' }}" data-index="{{ $i }}"></div>
            @endforeach
        </div>
    </div>
</div>

<!-- ===== PEMBATAS: KATALOG PRODUK -> HASIL NYATA ===== -->
<div class="divider-organic-wrap" style="background: var(--bg, #FAFAFA);">
    <svg class="divider-organic-svg" viewBox="0 0 1440 90" preserveAspectRatio="none">
        <path d="M0,0 C380,85 760,10 1140,75 C1290,100 1380,60 1440,40 L1440,90 L0,90 Z" fill="#F8F4FE"></path>
    </svg>
</div>

<!-- ===== SECTION 1: HASIL NYATA / BEFORE - AFTER (REFERENSI FOTO 1) ===== -->
<div class="before-after-wrapper-full" id="hasil-nyata">
    <div class="before-after-section">
        <div class="ba-header">
            <span class="ba-sub-kicker">HASIL NYATA</span>
            <h2 class="ba-title">MEREKA TELAH MENCOBA DAN MEMBUKTIKAN HASILNYA</h2>
        </div>

        <div class="ba-grid">
            @php
                $casesToDisplay = (isset($beforeAfterCases) && $beforeAfterCases->count() > 0)
                    ? $beforeAfterCases
                    : \App\Models\BeforeAfterCase::where('is_active', true)->orderBy('order', 'asc')->get();
            @endphp

            @forelse($casesToDisplay as $case)
                @php
                    $imgSrc = str_starts_with($case->image_path, 'images/')
                        ? asset($case->image_path)
                        : asset('storage/' . $case->image_path);
                @endphp
                <div class="ba-card">
                    <div class="ba-top-banner">
                        <div class="ba-clinic-watermark">
                            <span class="brand-name">Gitania</span>
                            <span class="brand-sub">Skin Clinic</span>
                        </div>
                        <div class="ba-pill-title">
                            {{ $case->case_title }}
                        </div>
                        <div class="ba-photo-wrapper">
                            <img src="{{ $imgSrc }}" alt="{{ $case->case_title }}" class="ba-photo-img" loading="lazy">
                            <div class="ba-censor-left"></div>
                            <div class="ba-censor-right"></div>
                            <div class="ba-pill-before">Before</div>
                            <div class="ba-pill-after">After</div>
                        </div>
                        <div class="ba-tag-sub">
                            <span>{{ $case->doctor_or_branch }}</span>
                            @if($case->hashtag)
                                <span class="hashtag">{{ $case->hashtag }}</span>
                            @endif
                        </div>
                    </div>
                    <div class="ba-desc-box">
                        <p>{{ $case->description }}</p>
                    </div>
                </div>
            @empty
                <div style="grid-column: 1 / -1; text-align: center; padding: 40px; color: var(--text-muted);">
                    Belum ada data Hasil Nyata yang ditampilkan.
                </div>
            @endforelse
        </div>
    </div>
</div>

<!-- ===== PEMBATAS: HASIL NYATA -> ULASAN KONSUMEN ===== -->
<div class="divider-organic-wrap" style="background: #F8F4FE;">
    <svg class="divider-organic-svg" viewBox="0 0 1440 90" preserveAspectRatio="none">
        <path d="M0,0 C360,75 720,15 1080,70 C1240,90 1360,50 1440,30 L1440,90 L0,90 Z" fill="#EDE5FA"></path>
    </svg>
</div>

<!-- ===== SECTION 2: ULASAN / TESTIMONI (REFERENSI FOTO 2) ===== -->
<div class="reviews-wrapper-full" id="ulasan-konsumen">
    <div class="reviews-container">
        <div class="reviews-header">
            <div>
                <div class="reviews-tag-badge">YANG MENGULAS TENTANG HASIL</div>
                <h2 class="reviews-title">
                    Cerita Indah Dari Sahabat Gitania Yang Telah Mencobanya, Yuk Giliranmu!
                </h2>
            </div>
            <div class="reviews-nav-btns">
                <button class="reviews-nav-btn" onclick="slideReviews('left')" aria-label="Review Sebelumnya">
                    ←
                </button>
                <button class="reviews-nav-btn" onclick="slideReviews('right')" aria-label="Review Selanjutnya">
                    →
                </button>
            </div>
        </div>

        <div class="reviews-slider-track" id="reviewsSliderTrack">
            @forelse($testimonials ?? [] as $testi)
                <div class="review-card">
                    <div>
                        <div class="review-top-meta">
                            <div class="review-user-info">
                                <div class="review-avatar" style="background: {{ $testi->avatar_gradient ?? 'linear-gradient(135deg, #7C3AED, #A855F7)' }};">
                                    {{ $testi->initial }}
                                </div>
                                <div>
                                    <div class="review-name">{{ $testi->name }}</div>
                                    @if($testi->badge)
                                        <div class="review-verified">✓ {{ $testi->badge }}</div>
                                    @endif
                                </div>
                            </div>
                            <div class="review-stars">
                                @for($i = 1; $i <= 5; $i++)
                                    @if($i <= $testi->rating)
                                        ★
                                    @else
                                        <span style="color: #CBD5E1;">★</span>
                                    @endif
                                @endfor
                            </div>
                        </div>
                        <p class="review-text">
                            "{{ $testi->comment }}"
                        </p>
                    </div>
                    @if($testi->product_tag)
                        <div class="review-product-tag">
                            {{ $testi->product_tag }}
                        </div>
                    @endif
                </div>
            @empty
                <div style="padding: 30px; color: #64748B; font-size: 14px;">Belum ada ulasan yang ditampilkan.</div>
            @endforelse
        </div>
    </div>
</div>

<!-- ===== PEMBATAS: ULASAN KONSUMEN -> FOOTER ===== -->
<div class="divider-reverse-wrap" style="background: #EDE5FA;">
    <svg class="divider-reverse-svg" viewBox="0 0 1440 85" preserveAspectRatio="none">
        <path d="M0,0 C420,80 980,80 1440,0 L1440,85 L0,85 Z" fill="#FFFFFF"></path>
    </svg>
</div>

<script>
// ===== REVIEWS SLIDER NAVIGATION =====
function slideReviews(direction) {
    const track = document.getElementById('reviewsSliderTrack');
    if (!track) return;
    const card = track.querySelector('.review-card');
    const scrollAmount = (card ? card.offsetWidth + 22 : 380);
    if (direction === 'left') {
        track.scrollBy({ left: -scrollAmount, behavior: 'smooth' });
    } else {
        track.scrollBy({ left: scrollAmount, behavior: 'smooth' });
    }
}

// ===== HERO SLIDER & HOVER ANIMATION =====
let currentHeroIndex = 0;
let heroAutoTimer = null;
const heroSlides = document.querySelectorAll('.hero-slide-item');
const heroPills = document.querySelectorAll('.hero-pill-btn');
const heroFrame = document.getElementById('heroSliderFrame');

function switchHeroSlide(index) {
    if (!heroSlides.length) return;
    currentHeroIndex = index % heroSlides.length;

    heroSlides.forEach((slide, i) => {
        slide.classList.toggle('active', i === currentHeroIndex);
    });

    heroPills.forEach((pill, i) => {
        pill.classList.toggle('active', i === currentHeroIndex);
    });
}

function startHeroAutoSlide() {
    stopHeroAutoSlide();
    if (heroSlides.length <= 1) return;
    heroAutoTimer = setInterval(() => {
        switchHeroSlide((currentHeroIndex + 1) % heroSlides.length);
    }, 4500);
}

function stopHeroAutoSlide() {
    if (heroAutoTimer) clearInterval(heroAutoTimer);
}

// Hover Transition: Saat kursor melewati gambar, beralih ke slide berikutnya
if (heroFrame && heroSlides.length > 1) {
    heroFrame.addEventListener('mouseenter', () => {
        stopHeroAutoSlide();
        switchHeroSlide((currentHeroIndex + 1) % heroSlides.length);
    });
    heroFrame.addEventListener('mouseleave', () => {
        startHeroAutoSlide();
    });
}

startHeroAutoSlide();

// ===== ADD TO CART =====
function addToCartHome(productId, btn) {
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
            }, 1800);
        })
        .catch(() => {
            btn.innerHTML = originalText;
            btn.disabled = false;
        });
}

// ===== CAROUSEL DOTS (MOBILE PRODUCTS) =====
(function() {
    const carousel = document.getElementById('productCarousel');
    if (!carousel) return;

    const dots = document.querySelectorAll('.carousel-dot');
    if (!dots.length) return;

    carousel.addEventListener('scroll', function() {
        const scrollLeft = carousel.scrollLeft;
        const cardWidth = carousel.querySelector('.product-card')?.offsetWidth + 16 || 300;
        const activeIndex = Math.round(scrollLeft / cardWidth);
        dots.forEach((d, i) => d.classList.toggle('active', i === activeIndex));
    }, { passive: true });

    dots.forEach((dot, i) => {
        dot.addEventListener('click', function() {
            const cardWidth = carousel.querySelector('.product-card')?.offsetWidth + 16 || 300;
            carousel.scrollTo({ left: i * cardWidth, behavior: 'smooth' });
        });
    });
})();
</script>
@endsection
