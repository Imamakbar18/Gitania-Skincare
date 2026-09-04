@extends('layouts.app')

@section('title', 'Tentang Kami — Gitania Skincare')

@section('content')
<style>
    /* ===================================================
       ABOUT US — THEME UNGU, LILAC & WHITE (LUXURY AESTHETIC)
    =================================================== */

    /* ===== HERO SECTION ===== */
    .about-hero-wrap {
        position: relative;
        background: linear-gradient(135deg, #FBF9FF 0%, #F5ECFD 45%, #EBE0FA 100%);
        padding: 90px 24px 120px 24px;
        text-align: center;
        overflow: hidden;
    }
    .about-hero-ambient {
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
    .about-hero-content {
        position: relative;
        z-index: 2;
        max-width: 820px;
        margin: 0 auto;
    }
    .about-pill-tag {
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
        margin-bottom: 22px;
        box-shadow: 0 4px 18px rgba(107, 33, 168, 0.07);
    }
    .about-hero-title {
        font-family: 'Playfair Display', serif;
        font-size: 52px;
        font-weight: 600;
        color: #1a162b;
        line-height: 1.15;
        margin: 0 0 20px 0;
        letter-spacing: -0.5px;
    }
    .about-hero-title span {
        background: linear-gradient(135deg, #6B21A8 0%, #9333EA 100%);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
    }
    .about-hero-desc {
        font-family: 'Poppins', sans-serif;
        color: #524765;
        font-size: 15px;
        line-height: 1.85;
        max-width: 620px;
        margin: 0 auto;
        font-weight: 400;
    }

    /* ===== PEMBATAS 1: LENGKUNGAN BUSUR GELOMBANG ESTETIK (HERO KE SECTION 1) ===== */
    .divider-wave-1 {
        position: relative;
        margin-top: -65px;
        line-height: 0;
        z-index: 3;
        overflow: hidden;
    }
    .divider-wave-1 svg {
        display: block;
        width: 100%;
        height: 65px;
    }
    .divider-wave-1 .fill-white {
        fill: #FFFFFF;
    }

    /* ===== STORY SECTION (WHITE BACKGROUND) ===== */
    .about-story-section-white {
        background: #FFFFFF;
        padding: 70px 24px 90px 24px;
        position: relative;
        z-index: 4;
    }
    .about-story-container {
        max-width: 1200px;
        margin: 0 auto;
    }
    .about-grid-row {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 60px;
        align-items: center;
    }
    .about-grid-row.reversed {
        grid-template-columns: 1fr 1fr;
    }

    /* Visual Card Framing */
    .about-visual-frame {
        position: relative;
        border-radius: 28px;
        overflow: hidden;
        background: linear-gradient(145deg, #F9F5FF 0%, #EDE5FC 100%);
        border: 2px solid rgba(221, 214, 254, 0.85);
        box-shadow: 0 20px 48px rgba(107, 33, 168, 0.10);
        aspect-ratio: 16 / 11;
        transition: transform 0.35s ease, box-shadow 0.35s ease;
    }
    .about-visual-frame:hover {
        transform: translateY(-6px);
        box-shadow: 0 28px 60px rgba(107, 33, 168, 0.16);
    }
    .about-visual-frame img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        display: block;
    }
    .about-visual-tag-badge {
        position: absolute;
        top: 18px;
        right: 18px;
        background: rgba(255, 255, 255, 0.92);
        backdrop-filter: blur(10px);
        padding: 7px 18px;
        border-radius: 999px;
        font-size: 11px;
        font-weight: 700;
        color: var(--primary);
        border: 1px solid rgba(221, 214, 254, 0.9);
        box-shadow: 0 4px 15px rgba(0,0,0,0.06);
        display: flex;
        align-items: center;
        gap: 6px;
    }

    /* Content Typography */
    .about-text-content {
        padding: 10px 0;
    }
    .story-tag-pill {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        background: #F5F3FF;
        color: #7C3AED;
        padding: 5px 16px;
        border-radius: 999px;
        font-size: 11px;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 1.2px;
        border: 1px solid #DDD6FE;
        margin-bottom: 16px;
    }
    .story-heading {
        font-family: 'Playfair Display', serif;
        font-size: 38px;
        font-weight: 600;
        color: #1a162b;
        line-height: 1.22;
        margin: 0 0 18px 0;
        letter-spacing: -0.4px;
    }
    .story-p {
        font-family: 'Poppins', sans-serif;
        color: #554a6b;
        font-size: 14.5px;
        line-height: 1.85;
        margin: 0 0 16px 0;
    }

    /* Feature Highlights in Story */
    .story-features-list {
        display: flex;
        flex-direction: column;
        gap: 12px;
        margin: 22px 0 28px 0;
    }
    .story-feature-item {
        display: flex;
        align-items: center;
        gap: 12px;
        font-size: 13.5px;
        font-weight: 600;
        color: #2D2638;
    }
    .story-feature-bullet {
        width: 26px;
        height: 26px;
        background: #EDE9FE;
        color: #6B21A8;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 12px;
        flex-shrink: 0;
        border: 1px solid #DDD6FE;
    }

    /* ===== PEMBATAS 2: UNIQUE ASYMMETRIC ORGANIC WAVE (SECTION 1 KE SECTION 2) ===== */
    .divider-organic-wrap {
        position: relative;
        background: #FFFFFF;
        line-height: 0;
        overflow: hidden;
    }
    .divider-organic-svg {
        display: block;
        width: 100%;
        height: 80px;
    }
    .divider-organic-svg .shape-lilac-bg {
        fill: #FBF8FF;
    }

    /* ===== SECTION 2: LILAC SOFT BACKGROUND ===== */
    .about-story-section-lilac {
        background: #FBF8FF;
        padding: 50px 24px 100px 24px;
        position: relative;
    }

    /* ===== PEMBATAS 3: REVERSE WAVE DIVIDER (SECTION 2 KE PILLARS) ===== */
    .divider-reverse-wrap {
        position: relative;
        background: #FBF8FF;
        line-height: 0;
        overflow: hidden;
    }
    .divider-reverse-svg {
        display: block;
        width: 100%;
        height: 75px;
    }
    .divider-reverse-svg .shape-white-fill {
        fill: #FFFFFF;
    }

    /* ===== CORE PILLARS / VALUES SECTION ===== */
    .about-pillars-section {
        background: #FFFFFF;
        padding: 80px 24px 90px 24px;
        position: relative;
    }
    .pillars-header {
        text-align: center;
        max-width: 680px;
        margin: 0 auto 50px auto;
    }
    .pillars-grid {
        max-width: 1200px;
        margin: 0 auto;
        display: grid;
        grid-template-columns: repeat(4, 1fr);
        gap: 24px;
    }
    .pillar-card {
        background: linear-gradient(145deg, #FFFFFF 0%, #FAF7FF 100%);
        border: 1.5px solid rgba(221, 214, 254, 0.8);
        border-radius: 22px;
        padding: 32px 24px;
        text-align: center;
        box-shadow: 0 8px 24px rgba(107, 33, 168, 0.04);
        transition: transform 0.3s ease, box-shadow 0.3s ease, border-color 0.3s;
    }
    .pillar-card:hover {
        transform: translateY(-8px);
        box-shadow: 0 18px 40px rgba(107, 33, 168, 0.12);
        border-color: #A855F7;
    }
    .pillar-icon-box {
        width: 58px;
        height: 58px;
        background: linear-gradient(135deg, #EDE9FE 0%, #DDD6FE 100%);
        color: var(--primary);
        border-radius: 18px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 26px;
        margin: 0 auto 18px auto;
        box-shadow: 0 6px 16px rgba(107, 33, 168, 0.10);
    }
    .pillar-title {
        font-family: 'Playfair Display', serif;
        font-size: 19px;
        font-weight: 600;
        color: #1a162b;
        margin: 0 0 10px 0;
    }
    .pillar-desc {
        font-size: 13px;
        color: #665c75;
        line-height: 1.65;
        margin: 0;
    }

    /* ===== CLINIC SECTION ===== */
    .about-clinic-wrap {
        background: #FBF8FF;
        padding: 50px 24px 90px 24px;
        position: relative;
    }

    /* ===== CERTIFICATION BADGES ===== */
    .certs-row-box {
        display: flex;
        gap: 16px;
        justify-content: center;
        flex-wrap: wrap;
        margin-top: 36px;
    }
    .cert-pill-badge {
        display: flex;
        align-items: center;
        gap: 10px;
        background: #FBF9FF;
        border: 1.5px solid #DDD6FE;
        padding: 12px 24px;
        border-radius: 999px;
        font-weight: 700;
        font-size: 13px;
        color: var(--primary);
        box-shadow: 0 4px 15px rgba(107, 33, 168, 0.05);
        transition: transform 0.2s;
    }
    .cert-pill-badge:hover {
        transform: translateY(-2px);
    }

    /* ===== RESPONSIVE BREAKPOINTS ===== */
    @media (max-width: 1024px) {
        .about-hero-title { font-size: 42px; }
        .story-heading { font-size: 32px; }
        .pillars-grid { grid-template-columns: repeat(2, 1fr); }
    }
    @media (max-width: 768px) {
        .about-hero-wrap { padding: 60px 18px 90px 18px; }
        .about-hero-title { font-size: 34px; }
        .about-grid-row, .about-grid-row.reversed {
            grid-template-columns: 1fr;
            gap: 36px;
        }
        .about-visual-frame {
            aspect-ratio: 16 / 10;
        }
        .about-story-section-white { padding: 50px 18px 60px 18px; }
        .about-story-section-lilac { padding: 40px 18px 60px 18px; }
        .story-heading { font-size: 28px; }
        .pillars-grid { grid-template-columns: 1fr; }
        .stat-ribbon-divider { display: none; }
        .stats-ribbon-inner { gap: 24px; }
        .stat-ribbon-num { font-size: 34px; }
    }
</style>

<!-- ===== 1. ABOUT HERO SECTION ===== -->
<div class="about-hero-wrap">
    <div class="about-hero-ambient"></div>
    <div class="about-hero-content">
        <span class="about-pill-tag">
            ✨ Clinical Care • Pure Beauty
        </span>
        <h1 class="about-hero-title">
            Merawat Kulit,<br>
            <span>Memberdayakan Pesona Alami</span>
        </h1>
        <p class="about-hero-desc">
            Gitania Skincare lahir untuk menghadirkan perawatan kulit berstandar klinis berkualitas tinggi yang aman, efektif, dan menutrisi setiap lapisan kulit wanita Indonesia.
        </p>

        <!-- Certifications Row Badges -->
        <div class="certs-row-box">
            <div class="cert-pill-badge">
                <span>🛡️</span> BPOM RI Certified
            </div>
            <div class="cert-pill-badge">
                <span>☪️</span> Halal Certified
            </div>
            <div class="cert-pill-badge">
                <span>🔬</span> Dermatologist Tested
            </div>
        </div>
    </div>
</div>

<!-- ===== PEMBATAS 1: LENGKUNGAN GELOMBANG ESTETIK (HERO -> STORY 1) ===== -->
<div class="divider-wave-1">
    <svg viewBox="0 0 1440 80" preserveAspectRatio="none">
        <path d="M0,0 C320,65 640,75 960,35 C1200,5 1360,25 1440,40 L1440,80 L0,80 Z" class="fill-white"></path>
    </svg>
</div>

<!-- ===== 2. PERJALANAN GITANIA SKINCARE (WHITE SECTION) ===== -->
<section class="about-story-section-white">
    <div class="about-story-container">
        <div class="about-grid-row">
            
            <!-- Kolom Visual Foto -->
            <div class="about-visual-frame">
                <div class="about-visual-tag-badge">
                    <span>✨</span> Signature Collection
                </div>
                <img src="{{ asset('images/gitania-hero-banner.jpg') }}" alt="Perjalanan Gitania Skincare" loading="lazy">
            </div>

            <!-- Kolom Teks Cerita -->
            <div class="about-text-content">
                <span class="story-tag-pill">About Us</span>
                <h2 class="story-heading">
                    Perjalanan Gitania<br>
                    Skincare
                </h2>
                <p class="story-p">
                    Gitania Skincare memulai perjalanan pada tahun 2023 sebagai local brand perawatan kulit dan tubuh secara profesional. Kami berkomitmen memberikan perawatan terbaik untuk wanita Indonesia dari Sabang sampai Merauke.
                </p>
                <p class="story-p">
                    Kini, Gitania Skincare telah berkembang menjadi brand yang tak hanya menyediakan perawatan wajah dan tubuh secara terpadu, tetapi juga menghadirkan inovasi estetika modern dengan teknologi klinis mutakhir.
                </p>

                <div class="story-features-list">
                    <div class="story-feature-item">
                        <div class="story-feature-bullet">✓</div>
                        <span>Formulasi klinis ramah untuk semua jenis kulit</span>
                    </div>
                    <div class="story-feature-item">
                        <div class="story-feature-bullet">✓</div>
                        <span>Bahan aktif alami dengan efektivitas terbukti</span>
                    </div>
                </div>

                <a href="{{ route('shop.index') }}" class="btn-primary" style="display: inline-flex; align-items: center; gap: 8px; padding: 13px 30px; border-radius: 999px; font-size: 13px; font-weight: 700; text-decoration: none; box-shadow: 0 6px 20px rgba(107,33,168,0.28);">
                    Jelajahi Produk Kami →
                </a>
            </div>

        </div>
    </div>
</section>

<!-- ===== PEMBATAS 2: ASYMMETRIC ORGANIC WAVE (STORY 1 -> STORY 2) ===== -->
<div class="divider-organic-wrap">
    <svg class="divider-organic-svg" viewBox="0 0 1440 90" preserveAspectRatio="none">
        <path d="M0,0 C380,85 760,10 1140,75 C1290,100 1380,60 1440,40 L1440,90 L0,90 Z" class="shape-lilac-bg"></path>
    </svg>
</div>

<!-- ===== 3. BRAND STORY (LILAC SOFT SECTION) ===== -->
<section class="about-story-section-lilac">
    <div class="about-story-container">
        <div class="about-grid-row reversed">

            <!-- Kolom Teks Brand Story -->
            <div class="about-text-content">
                <span class="story-tag-pill">Brand Story</span>
                <h2 class="story-heading">
                    Lahir dari Cinta untuk<br>
                    Kulit Indonesia
                </h2>
                <p class="story-p">
                    Gitania adalah sebuah brand kecantikan di bawah naungan PT. Kosmetika Cantik Indonesia. Berdiri dari moto perawatan berkualitas klinis, kami berupaya menjangkau seluruh kalangan dari remaja hingga dewasa.
                </p>
                <p class="story-p">
                    Setiap produk Gitania diformulasikan khusus untuk iklim tropis Indonesia, memadukan bahan-bahan premium yang telah melalui uji klinis ketat demi memastikan keamanan, kenyamanan, dan hasil glowing maksimal.
                </p>

                <div class="story-features-list">
                    <div class="story-feature-item">
                        <div class="story-feature-bullet">✓</div>
                        <span>Disesuaikan untuk kelembapan &amp; suhu tropis</span>
                    </div>
                    <div class="story-feature-item">
                        <div class="story-feature-bullet">✓</div>
                        <span>Bebas bahan kimia berbahaya &amp; aman jangka panjang</span>
                    </div>
                </div>
            </div>

            <!-- Kolom Visual Foto 2 (Sunscreen Serum Photo) -->
            <div class="about-visual-frame">
                <div class="about-visual-tag-badge">
                    <span>☀️</span> Tropical Care
                </div>
                <img src="{{ asset('images/gitania-hero-banner-2.jpg') }}" alt="Brand Story Gitania Skincare" loading="lazy">
            </div>

        </div>
    </div>
</section>

<!-- ===== PEMBATAS 3: REVERSE SCOOP WAVE (STORY 2 -> PILLARS) ===== -->
<div class="divider-reverse-wrap">
    <svg class="divider-reverse-svg" viewBox="0 0 1440 85" preserveAspectRatio="none">
        <path d="M0,0 C420,80 980,80 1440,0 L1440,85 L0,85 Z" class="shape-white-fill"></path>
    </svg>
</div>

<!-- ===== 4. CORE VALUES & PILLARS ===== -->
<section class="about-pillars-section">
    <div class="pillars-header">
        <span class="story-tag-pill">Nilai Utama Kami</span>
        <h2 class="story-heading">Komitmen Kualitas Tanpa Kompromi</h2>
        <p class="story-p">
            Kami memadukan sains dermatologi modern dengan kebaikan alam untuk menghadirkan pengalaman perawatan kulit terbaik.
        </p>
    </div>

    <div class="pillars-grid">
        <!-- Pilar 1 -->
        <div class="pillar-card">
            <div class="pillar-icon-box">🔬</div>
            <h3 class="pillar-title">Clinical Efficacy</h3>
            <p class="pillar-desc">Setiap formula melewati uji klinis ketat untuk menjamin hasil nyata yang terbukti.</p>
        </div>

        <!-- Pilar 2 -->
        <div class="pillar-card">
            <div class="pillar-icon-box">🌿</div>
            <h3 class="pillar-title">Pure Ingredients</h3>
            <p class="pillar-desc">Hanya menggunakan ekstrak alami bermutu tinggi tanpa zat kimia agresif.</p>
        </div>

        <!-- Pilar 3 -->
        <div class="pillar-card">
            <div class="pillar-icon-box">🛡️</div>
            <h3 class="pillar-title">Safe &amp; Certified</h3>
            <p class="pillar-desc">100% resmi BPOM dan Halal MUI, aman untuk ibu hamil dan menyusui.</p>
        </div>

        <!-- Pilar 4 -->
        <div class="pillar-card">
            <div class="pillar-icon-box">☀️</div>
            <h3 class="pillar-title">Tropical Skin Match</h3>
            <p class="pillar-desc">Tekstur ringan, cepat meresap, dan tidak menyumbat pori di iklim tropis.</p>
        </div>
    </div>
</section>

<!-- ===== PEMBATAS: ASYMMETRIC ORGANIC WAVE (PILLARS -> KLINIK KAMI) ===== -->
<div class="divider-organic-wrap">
    <svg class="divider-organic-svg" viewBox="0 0 1440 90" preserveAspectRatio="none">
        <path d="M0,0 C380,85 760,10 1140,75 C1290,100 1380,60 1440,40 L1440,90 L0,90 Z" class="shape-lilac-bg"></path>
    </svg>
</div>

<!-- ===== 5. CLINIC SECTION ===== -->
<section class="about-clinic-wrap">
    <div class="about-story-container">
        <div class="about-grid-row">
            
            <!-- Kolom Visual Clinic (Foto Asli Klinik Pratama Rumah Hanania) -->
            <div class="about-visual-frame">
                <div class="about-visual-tag-badge">
                    <span>🏥</span> Klinik Pratama
                </div>
                <img src="{{ asset('images/klinik-gitania.jpg') }}?v={{ filemtime(public_path('images/klinik-gitania.jpg')) }}" alt="Klinik Pratama Rumah Hanania" loading="lazy" style="object-position: center;">
            </div>

            <!-- Kolom Teks Clinic -->
            <div class="about-text-content">
                <span class="story-tag-pill">Klinik Kami</span>
                <h2 class="story-heading">
                    Klinik Pratama<br>
                    Rumah Hanania
                </h2>
                <p class="story-p">
                    Klinik Pratama Rumah Hanania menghadirkan solusi perawatan estetika wajah dan tubuh profesional. Didukung oleh dokter ahli berpengalaman serta fasilitas medis modern yang higienis, nyaman, dan terpercaya.
                </p>
                <p class="story-p">
                    Dari perawatan kulit intensif, peremajaan kulit, hingga konsultasi dermatologi personal — kami siap memberikan penanganan terbaik untuk kesehatan dan kecantikan kulit Anda.
                </p>

                <div class="story-features-list">
                    <div class="story-feature-item">
                        <div class="story-feature-bullet">✓</div>
                        <span>Dokter &amp; Tenaga Medis Bersertifikat Resmi</span>
                    </div>
                    <div class="story-feature-item">
                        <div class="story-feature-bullet">✓</div>
                        <span>Fasilitas Estetika Modern, Nyaman &amp; Higienis</span>
                    </div>
                    <div class="story-feature-item">
                        <div class="story-feature-bullet">✓</div>
                        <span>Konsultasi Personal Sesuai Kebutuhan Kulit Anda</span>
                    </div>
                </div>

                <div style="display: flex; gap: 14px; flex-wrap: wrap; margin-top: 8px;">
                    <a href="https://maps.app.goo.gl/3fYrzRT73RgSDUEM7" target="_blank" class="btn-primary" style="display: inline-flex; align-items: center; gap: 8px; padding: 13px 28px; border-radius: 999px; font-size: 13px; font-weight: 700; text-decoration: none; box-shadow: 0 6px 20px rgba(107,33,168,0.28);">
                        📍 Buka Lokasi di Google Maps →
                    </a>
                    <a href="{{ route('contact') }}" class="btn-outline" style="display: inline-flex; align-items: center; gap: 8px; padding: 12px 24px; border-radius: 999px; font-size: 13px; font-weight: 600; text-decoration: none;">
                        💬 Hubungi Kami
                    </a>
                </div>
            </div>

        </div>
    </div>
</section>

<!-- ===== PEMBATAS: REVERSE SCOOP WAVE (KLINIK KAMI -> FOOTER) ===== -->
<div class="divider-reverse-wrap">
    <svg class="divider-reverse-svg" viewBox="0 0 1440 85" preserveAspectRatio="none">
        <path d="M0,0 C420,80 980,80 1440,0 L1440,85 L0,85 Z" class="shape-white-fill"></path>
    </svg>
</div>

@endsection
