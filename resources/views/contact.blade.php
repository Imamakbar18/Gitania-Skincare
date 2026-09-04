@extends('layouts.app')

@section('title', 'Hubungi Kami — Gitania Skincare')

@section('content')
<style>
    /* ===================================================
       CONTACT US — THEME UNGU, LILAC & WHITE (LUXURY AESTHETIC)
    =================================================== */

    /* ===== HERO SECTION ===== */
    .contact-hero-wrap {
        position: relative;
        background: linear-gradient(135deg, #FBF9FF 0%, #F5ECFD 45%, #EBE0FA 100%);
        padding: 90px 24px 110px 24px;
        text-align: center;
        overflow: hidden;
    }
    .contact-hero-ambient {
        position: absolute;
        top: -120px;
        left: 50%;
        transform: translateX(-50%);
        width: 600px;
        height: 600px;
        background: radial-gradient(circle, rgba(168, 85, 247, 0.15) 0%, rgba(221, 214, 254, 0.05) 50%, transparent 70%);
        border-radius: 50%;
        pointer-events: none;
        z-index: 1;
    }
    .contact-hero-content {
        position: relative;
        z-index: 2;
        max-width: 800px;
        margin: 0 auto;
    }
    .contact-pill-tag {
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
    .contact-hero-title {
        font-family: 'Playfair Display', serif;
        font-size: 50px;
        font-weight: 600;
        color: #1a162b;
        line-height: 1.18;
        margin: 0 0 18px 0;
        letter-spacing: -0.5px;
    }
    .contact-hero-title span {
        background: linear-gradient(135deg, #6B21A8 0%, #9333EA 100%);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
    }
    .contact-hero-desc {
        font-family: 'Poppins', sans-serif;
        color: #524765;
        font-size: 15px;
        line-height: 1.85;
        max-width: 580px;
        margin: 0 auto;
        font-weight: 400;
    }

    /* ===== PEMBATAS 1: LENGKUNGAN GELOMBANG ESTETIK ===== */
    .divider-wave-contact {
        position: relative;
        margin-top: -65px;
        line-height: 0;
        z-index: 3;
        overflow: hidden;
    }
    .divider-wave-contact svg {
        display: block;
        width: 100%;
        height: 65px;
    }
    .divider-wave-contact .fill-white {
        fill: #FFFFFF;
    }

    /* ===== CARDS SECTION (WHITE BACKGROUND) ===== */
    .contact-cards-section {
        background: #FFFFFF;
        padding: 70px 24px 90px 24px;
        position: relative;
        z-index: 4;
    }
    .contact-container {
        max-width: 1200px;
        margin: 0 auto;
    }
    .contact-section-header {
        text-align: center;
        max-width: 650px;
        margin: 0 auto 50px auto;
    }
    .contact-section-heading {
        font-family: 'Playfair Display', serif;
        font-size: 38px;
        font-weight: 600;
        color: #1a162b;
        margin: 0 0 12px 0;
    }
    .contact-section-sub {
        font-family: 'Poppins', sans-serif;
        color: #665c75;
        font-size: 14px;
        margin: 0;
    }

    /* 3 Column Grid */
    .contact-cards-grid {
        display: grid;
        grid-template-columns: repeat(3, 1fr);
        gap: 28px;
    }
    .contact-card {
        background: linear-gradient(145deg, #FFFFFF 0%, #FAF8FF 100%);
        border-radius: 24px;
        border: 1.5px solid rgba(221, 214, 254, 0.85);
        box-shadow: 0 10px 30px rgba(107, 33, 168, 0.05);
        overflow: hidden;
        display: flex;
        flex-direction: column;
        transition: transform 0.3s ease, box-shadow 0.3s ease, border-color 0.3s;
    }
    .contact-card:hover {
        transform: translateY(-8px);
        box-shadow: 0 20px 48px rgba(107, 33, 168, 0.14);
        border-color: #A855F7;
    }
    .contact-card-banner {
        height: 150px;
        background: linear-gradient(135deg, #F3EBFF 0%, #E8DCFE 100%);
        display: flex;
        align-items: center;
        justify-content: center;
        position: relative;
        border-bottom: 1px solid rgba(221, 214, 254, 0.8);
    }
    .contact-card-banner img {
        width: 76px;
        height: 76px;
        object-fit: contain;
        border-radius: 18px;
        box-shadow: 0 8px 22px rgba(107, 33, 168, 0.12);
        transition: transform 0.35s ease;
    }
    .contact-card:hover .contact-card-banner img {
        transform: scale(1.12);
    }
    .contact-card-body {
        padding: 28px 24px;
        flex: 1;
        display: flex;
        flex-direction: column;
        justify-content: space-between;
    }
    .contact-card-title {
        font-family: 'Playfair Display', serif;
        font-size: 21px;
        font-weight: 600;
        color: #1a162b;
        margin: 0 0 10px 0;
    }
    .contact-card-desc {
        font-size: 13.5px;
        color: #5f5475;
        line-height: 1.7;
        margin: 0 0 22px 0;
    }
    .contact-card-link {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        background: white;
        color: var(--primary);
        padding: 10px 20px;
        border-radius: 999px;
        font-size: 12.5px;
        font-weight: 700;
        text-decoration: none;
        border: 1.5px solid var(--primary-border);
        box-shadow: 0 4px 12px rgba(107, 33, 168, 0.05);
        transition: all 0.25s ease;
        align-self: flex-start;
    }
    .contact-card-link:hover {
        background: var(--primary);
        color: white;
        border-color: var(--primary);
        transform: translateY(-2px);
        box-shadow: 0 6px 18px rgba(107, 33, 168, 0.25);
    }

    /* ===== PEMBATAS 2: ASYMMETRIC ORGANIC WAVE KE SECTION LOKASI ===== */
    .divider-organic-contact {
        position: relative;
        background: #FFFFFF;
        line-height: 0;
        overflow: hidden;
    }
    .divider-organic-contact svg {
        display: block;
        width: 100%;
        height: 80px;
    }
    .divider-organic-contact .shape-lilac-bg {
        fill: #FBF8FF;
    }

    /* ===== LOCATION & CLINIC SECTION (LILAC BACKGROUND) ===== */
    .contact-location-section {
        background: #FBF8FF;
        padding: 60px 24px 100px 24px;
        position: relative;
    }
    .location-grid {
        display: grid;
        grid-template-columns: 1fr 1.2fr;
        gap: 50px;
        align-items: center;
    }

    /* Visual Map Card */
    .location-map-frame {
        background: white;
        border-radius: 28px;
        border: 2px solid rgba(221, 214, 254, 0.85);
        box-shadow: 0 16px 45px rgba(107, 33, 168, 0.10);
        overflow: hidden;
        text-decoration: none;
        color: inherit;
        display: block;
        transition: transform 0.3s ease, box-shadow 0.3s ease;
    }
    .location-map-frame:hover {
        transform: translateY(-6px);
        box-shadow: 0 24px 55px rgba(107, 33, 168, 0.16);
    }
    .location-map-top-banner {
        height: 240px;
        background: linear-gradient(145deg, #F5ECFD 0%, #E8DCFE 100%);
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
        position: relative;
        overflow: hidden;
    }
    .location-map-top-banner img {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }
    .location-map-badge {
        position: absolute;
        top: 16px;
        left: 16px;
        background: rgba(255, 255, 255, 0.92);
        backdrop-filter: blur(8px);
        padding: 6px 16px;
        border-radius: 999px;
        font-size: 11px;
        font-weight: 700;
        color: var(--primary);
        border: 1px solid rgba(221, 214, 254, 0.9);
    }
    .location-map-bottom-bar {
        padding: 18px 24px;
        background: white;
        display: flex;
        align-items: center;
        justify-content: space-between;
        border-top: 1px solid rgba(221, 214, 254, 0.6);
    }

    /* Info Boxes on Right */
    .contact-info-list {
        display: flex;
        flex-direction: column;
        gap: 14px;
        margin-top: 24px;
    }
    .contact-info-card {
        background: white;
        border: 1.5px solid rgba(221, 214, 254, 0.75);
        border-radius: 18px;
        padding: 18px 22px;
        display: flex;
        gap: 16px;
        align-items: flex-start;
        box-shadow: 0 4px 16px rgba(107, 33, 168, 0.03);
        transition: border-color 0.2s, transform 0.2s;
    }
    .contact-info-card:hover {
        border-color: #A855F7;
        transform: translateY(-2px);
    }
    .contact-info-icon-box {
        width: 44px;
        height: 44px;
        background: linear-gradient(135deg, #F3EBFF 0%, #E8DCFE 100%);
        color: var(--primary);
        border-radius: 12px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 20px;
        flex-shrink: 0;
        border: 1px solid rgba(221, 214, 254, 0.8);
    }
    .contact-info-label {
        font-size: 11px;
        font-weight: 700;
        color: #7C3AED;
        text-transform: uppercase;
        letter-spacing: 0.8px;
        margin-bottom: 4px;
    }
    .contact-info-value {
        font-size: 13.5px;
        color: #2D2638;
        font-weight: 500;
        line-height: 1.5;
    }

    /* ===== RESPONSIVE BREAKPOINTS ===== */
    @media (max-width: 1024px) {
        .contact-hero-title { font-size: 42px; }
        .contact-cards-grid { grid-template-columns: repeat(2, 1fr); }
        .location-grid { grid-template-columns: 1fr; gap: 40px; }
    }
    @media (max-width: 768px) {
        .contact-hero-wrap { padding: 60px 18px 90px 18px; }
        .contact-hero-title { font-size: 34px; }
        .contact-cards-grid { grid-template-columns: 1fr; }
        .contact-cards-section { padding: 50px 18px 60px 18px; }
        .contact-location-section { padding: 40px 18px 70px 18px; }
        .contact-section-heading { font-size: 28px; }
    }
</style>

<!-- ===== 1. CONTACT HERO SECTION ===== -->
<div class="contact-hero-wrap">
    <div class="contact-hero-ambient"></div>
    <div class="contact-hero-content">
        <span class="contact-pill-tag">
            ✨ Customer Support • Partnership
        </span>
        <h1 class="contact-hero-title">
            Hubungi Kami,<br>
            <span>Kami Siap Mendengar &amp; Membantu</span>
        </h1>
        <p class="contact-hero-desc">
            Punya pertanyaan seputar produk, konsultasi perawatan kulit, atau berminat bergabung sebagai mitra resmi Gitania Skincare? Tim kami siap melayani Anda.
        </p>
    </div>
</div>

<!-- ===== PEMBATAS 1: LENGKUNGAN GELOMBANG ESTETIK (HERO -> CARDS) ===== -->
<div class="divider-wave-contact">
    <svg viewBox="0 0 1440 80" preserveAspectRatio="none">
        <path d="M0,0 C320,65 640,75 960,35 C1200,5 1360,25 1440,40 L1440,80 L0,80 Z" class="fill-white"></path>
    </svg>
</div>

<!-- ===== 2. CONTACT CARDS (WHITE SECTION) ===== -->
<section class="contact-cards-section">
    <div class="contact-container">
        
        <div class="contact-section-header">
            <span class="contact-pill-tag" style="margin-bottom: 12px;">Layanan Bantuan</span>
            <h2 class="contact-section-heading">Bagaimana Kami Bisa Membantu?</h2>
            <p class="contact-section-sub">Pilih jalur komunikasi yang paling sesuai dengan kebutuhan Anda</p>
        </div>

        <div class="contact-cards-grid">

            <!-- Card 1: Hubungi Admin CS (WhatsApp) -->
            <div class="contact-card">
                <div class="contact-card-banner">
                    <img src="{{ asset('images/contact/whatsapp.jpg') }}" alt="WhatsApp Admin CS">
                </div>
                <div class="contact-card-body">
                    <div>
                        <h3 class="contact-card-title">Hubungi Admin CS</h3>
                        <p class="contact-card-desc">Layanan cepat via WhatsApp untuk konsultasi produk kecantikan, info pengiriman, atau kendala transaksi bersama Beauty Advisor kami.</p>
                    </div>
                    <a href="https://wa.me/6283815086540?text=Halo%20Admin%20CS%20Gitania%20Skincare,%20saya%20ingin%20bertanya" target="_blank" class="contact-card-link">
                        Chat Admin CS →
                    </a>
                </div>
            </div>

            <!-- Card 2: DM via Instagram -->
            <div class="contact-card">
                <div class="contact-card-banner">
                    <img src="{{ asset('images/contact/instagram.png') }}" alt="Instagram Gitania Skincare">
                </div>
                <div class="contact-card-body">
                    <div>
                        <h3 class="contact-card-title">DM via Instagram</h3>
                        <p class="contact-card-desc">Ikuti update produk terbaru, tips perawatan kulit glowing, dan kirim pesan langsung melalui Direct Message (DM) Instagram kami.</p>
                    </div>
                    <a href="https://www.instagram.com/gitaniaskincare.official?utm_source=ig_web_button_share_sheet&igsi=ZDNlZDc0MzIxNw==" target="_blank" class="contact-card-link">
                        Kirim DM Instagram →
                    </a>
                </div>
            </div>

            <!-- Card 3: via Gmail / Email -->
            <div class="contact-card">
                <div class="contact-card-banner">
                    <img src="{{ asset('images/contact/gmail.webp') }}" alt="Gmail Gitania Skincare">
                </div>
                <div class="contact-card-body">
                    <div>
                        <h3 class="contact-card-title">via Gmail / Email</h3>
                        <p class="contact-card-desc">Kirimkan pertanyaan resmi, proposal kerjasama, atau masukan pelanggan langsung ke alamat email resmi Gitania Skincare.</p>
                    </div>
                    <a href="mailto:skincaregitania@gmail.com" class="contact-card-link">
                        Kirim Email Kami →
                    </a>
                </div>
            </div>

        </div>

    </div>
</section>

<!-- ===== PEMBATAS 2: ASYMMETRIC ORGANIC WAVE (CARDS -> LOCATION) ===== -->
<div class="divider-organic-contact">
    <svg viewBox="0 0 1440 90" preserveAspectRatio="none">
        <path d="M0,0 C380,85 760,10 1140,75 C1290,100 1380,60 1440,40 L1440,90 L0,90 Z" class="shape-lilac-bg"></path>
    </svg>
</div>

<!-- ===== 3. LOCATION & CLINIC SECTION (LILAC SECTION) ===== -->
<section class="contact-location-section">
    <div class="contact-container">
        
        <div class="location-grid">

            <!-- Kolom Visual Map & Clinic Frame -->
            <a href="https://maps.app.goo.gl/3fYrzRT73RgSDUEM7" target="_blank" class="location-map-frame">
                <div class="location-map-top-banner">
                    <div class="location-map-badge">
                        <span>🏥</span> Klinik Pratama Rumah Hanania
                    </div>
                    <img src="{{ asset('images/klinik-gitania.jpg') }}" alt="Klinik Pratama Rumah Hanania &amp; Gitania Office" loading="lazy">
                </div>
                <div class="location-map-bottom-bar">
                    <div>
                        <div style="font-weight: 700; color: #1a162b; font-size: 14px;">Klinik Pratama Rumah Hanania</div>
                        <div style="font-size: 12px; color: #7C3AED; font-weight: 500;">Kota Bogor, Jawa Barat</div>
                    </div>
                    <span style="display: inline-flex; align-items: center; gap: 6px; color: var(--primary); font-size: 13px; font-weight: 700;">
                        📍 Buka di Google Maps →
                    </span>
                </div>
            </a>

            <!-- Kolom Detail Kontak & Jam Operasional -->
            <div>
                <span class="contact-pill-tag" style="margin-bottom: 12px;">Kantor &amp; Klinik Pusat</span>
                <h2 class="contact-section-heading" style="margin-bottom: 10px;">Gitania Office &amp; Clinic</h2>
                <p class="contact-section-sub" style="line-height: 1.7; margin-bottom: 20px;">
                    Kunjungi klinik dan kantor pusat kami untuk konsultasi langsung dengan dokter kulit atau pengambilan produk.
                </p>

                <div class="contact-info-list">
                    <!-- Alamat -->
                    <div class="contact-info-card">
                        <div class="contact-info-icon-box">📍</div>
                        <div>
                            <div class="contact-info-label">Alamat Lengkap</div>
                            <div class="contact-info-value">Rumah Hanania (Praktek Bersama Dokter dan Bidan), Jl. Desa Sukadamai No.RT 01, RT.01/RW.06, Sukadamai, Tanah Sareal, Kota Bogor, Jawa Barat 16165</div>
                        </div>
                    </div>

                    <!-- Telepon -->
                    <div class="contact-info-card">
                        <div class="contact-info-icon-box">📞</div>
                        <div>
                            <div class="contact-info-label">Nomor Telepon</div>
                            <div class="contact-info-value" style="font-weight: 700; color: var(--primary);">(0341) 3022814</div>
                        </div>
                    </div>

                    <!-- Email -->
                    <div class="contact-info-card">
                        <div class="contact-info-icon-box">✉️</div>
                        <div>
                            <div class="contact-info-label">Email Resmi</div>
                            <div class="contact-info-value">
                                <a href="mailto:publicrelation@gitaniaskincare.com" style="color: var(--primary); font-weight: 600; text-decoration: none;">publicrelation@gitaniaskincare.com</a>
                            </div>
                        </div>
                    </div>

                    <!-- Jam Operasional -->
                    <div class="contact-info-card">
                        <div class="contact-info-icon-box">🕐</div>
                        <div>
                            <div class="contact-info-label">Jam Operasional</div>
                            <div class="contact-info-value">
                                Senin – Jumat: 08.00 – 17.00 WIB<br>
                                Sabtu: 08.00 – 13.00 WIB
                            </div>
                        </div>
                    </div>
                </div>

                <div style="margin-top: 24px;">
                    <a href="https://maps.app.goo.gl/3fYrzRT73RgSDUEM7" target="_blank" class="btn-primary" style="display: inline-flex; align-items: center; gap: 8px; padding: 13px 30px; border-radius: 999px; font-size: 13px; font-weight: 700; text-decoration: none; box-shadow: 0 6px 20px rgba(107,33,168,0.28);">
                        🗺️ Petunjuk Arah Google Maps →
                    </a>
                </div>

            </div>

        </div>

    </div>
</section>

@endsection
