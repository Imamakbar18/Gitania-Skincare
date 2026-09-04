<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('title', 'Admin Panel - Gitania Skincare')</title>

    <!-- Google Fonts Poppins & Inter -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&family=Poppins:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        :root {
            --admin-purple: #5a2e88;
            --admin-purple-dark: #431f68;
            --admin-purple-light: #7c3aed;
            --admin-purple-soft: #f3e8ff;
            --admin-purple-pale: #faf5ff;
            --admin-border: #f1f5f9;
            --admin-bg: #f8fafc;
            --admin-text-dark: #1e293b;
            --admin-text-muted: #64748b;
            --admin-card-bg: #ffffff;
            --admin-sidebar-bg: #ffffff;
            --admin-topbar-bg: #ffffff;
        }

        /* ─── DARK MODE ─── */
        html.dark-mode {
            --admin-bg: #0f0f1a;
            --admin-card-bg: #1a1a2e;
            --admin-sidebar-bg: #12122a;
            --admin-topbar-bg: #16163a;
            --admin-border: #2e2e50;
            --admin-text-dark: #e2e8f0;
            --admin-text-muted: #94a3b8;
            --admin-purple-pale: #1a0e2e;
            --admin-purple-soft: #2a1a45;
        }
        html.dark-mode body {
            background: var(--admin-bg);
            color: var(--admin-text-dark);
        }
        html.dark-mode .admin-sidebar {
            background: var(--admin-sidebar-bg);
            border-right-color: var(--admin-border);
        }
        html.dark-mode .admin-topbar {
            background: var(--admin-topbar-bg);
            border-bottom-color: var(--admin-border);
        }
        html.dark-mode .admin-card {
            background: var(--admin-card-bg) !important;
            border-color: var(--admin-border) !important;
            color: var(--admin-text-dark);
        }
        html.dark-mode .admin-card h3,
        html.dark-mode .admin-card strong,
        html.dark-mode .admin-card p,
        html.dark-mode .admin-card span {
            color: inherit;
        }
        html.dark-mode .admin-sidebar-footer {
            background: var(--admin-purple-pale);
            border-color: var(--admin-purple-soft);
        }
        html.dark-mode .admin-nav-link {
            color: var(--admin-text-muted);
        }
        html.dark-mode .admin-nav-link:hover,
        html.dark-mode .admin-nav-link.active {
            background: var(--admin-purple-soft);
            color: #c4b5fd;
        }
        html.dark-mode .admin-brand-text {
            color: var(--admin-text-dark);
        }
        html.dark-mode .admin-topbar-title {
            color: var(--admin-text-dark);
        }
        html.dark-mode .admin-user-name {
            color: #94a3b8;
        }
        html.dark-mode .admin-avatar {
            background: var(--admin-purple-soft);
            border-color: #7c3aed;
        }
        html.dark-mode .admin-menu-toggle {
            background: #1e1e38;
            border-color: var(--admin-border);
            color: var(--admin-text-dark);
        }
        html.dark-mode table thead tr {
            background: #1e1e38 !important;
            color: #94a3b8 !important;
        }
        html.dark-mode table tbody tr td {
            color: var(--admin-text-dark) !important;
            border-bottom-color: var(--admin-border) !important;
        }

        /* Tombol Dark/Light Mode */
        .theme-toggle-btn {
            display: flex;
            align-items: center;
            gap: 6px;
            padding: 7px 14px;
            border-radius: 20px;
            border: 1.5px solid var(--admin-border);
            background: var(--admin-bg);
            color: var(--admin-text-dark);
            font-size: 12.5px;
            font-weight: 600;
            cursor: pointer;
            transition: all .2s;
            font-family: 'Inter', sans-serif;
            white-space: nowrap;
            flex-shrink: 0;
        }
        .theme-toggle-btn:hover {
            background: var(--admin-purple-soft);
            border-color: var(--admin-purple-light);
            color: var(--admin-purple);
        }
        html.dark-mode .theme-toggle-btn {
            background: #1e1e38;
            border-color: #3a3a5c;
            color: #c4b5fd;
        }
        html.dark-mode .theme-toggle-btn:hover {
            background: #2a2a4a;
            border-color: #7c3aed;
        }

        *, *::before, *::after {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
        }

        body {
            background: var(--admin-bg);
            font-family: 'Inter', sans-serif;
            color: var(--admin-text-dark);
            min-height: 100vh;
            overflow-x: hidden;
        }

        /* ===== ADMIN LAYOUT WRAPPER ===== */
        .admin-layout {
            display: flex;
            min-height: 100vh;
            position: relative;
        }

        /* ===== SIDEBAR BACKDROP (MOBILE/TABLET) ===== */
        .admin-backdrop {
            display: none;
            position: fixed;
            inset: 0;
            background: rgba(15, 23, 42, 0.45);
            backdrop-filter: blur(3px);
            z-index: 99998;
            transition: opacity 0.3s ease;
        }
        .admin-backdrop.active {
            display: block;
        }

        /* ===== SIDEBAR ADMIN ===== */
        .admin-sidebar {
            width: 260px;
            background: #ffffff;
            border-right: 1px solid var(--admin-border);
            padding: 24px 18px;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
            position: fixed;
            left: 0;
            top: 0;
            height: 100vh;
            overflow-y: auto;
            z-index: 99999;
            transition: left 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            scrollbar-width: thin;
        }

        .admin-sidebar-header {
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin-bottom: 28px;
            padding-bottom: 14px;
            border-bottom: 1px solid var(--admin-border);
        }

        .admin-brand {
            display: flex;
            align-items: center;
            gap: 10px;
            text-decoration: none;
        }

        .admin-brand-icon {
            width: 36px;
            height: 36px;
            background: linear-gradient(135deg, var(--admin-purple) 0%, var(--admin-purple-light) 100%);
            border-radius: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-weight: 800;
            font-size: 17px;
            font-family: 'Poppins', sans-serif;
            flex-shrink: 0;
        }

        .admin-brand-text {
            color: var(--admin-text-dark);
            font-weight: 700;
            font-size: 15px;
            font-family: 'Poppins', sans-serif;
            line-height: 1.2;
        }
        .admin-brand-badge {
            font-size: 10px;
            color: var(--admin-purple);
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .admin-sidebar-close {
            display: none;
            background: #f1f5f9;
            border: none;
            width: 32px;
            height: 32px;
            border-radius: 8px;
            font-size: 16px;
            color: #64748b;
            cursor: pointer;
            align-items: center;
            justify-content: center;
        }

        .admin-nav {
            list-style: none;
            padding: 0;
            margin: 0;
            display: flex;
            flex-direction: column;
            gap: 6px;
        }

        .admin-nav-link {
            display: flex;
            align-items: center;
            gap: 12px;
            padding: 11px 14px;
            border-radius: 12px;
            text-decoration: none;
            font-size: 14px;
            font-weight: 500;
            color: var(--admin-text-muted);
            transition: all 0.2s ease;
        }
        .admin-nav-link:hover {
            background: var(--admin-purple-soft);
            color: var(--admin-purple);
            transform: translateX(2px);
        }
        .admin-nav-link.active {
            background: var(--admin-purple-soft);
            color: var(--admin-purple);
            font-weight: 700;
        }

        .admin-sidebar-footer {
            margin-top: 20px;
            background: var(--admin-purple-pale);
            padding: 14px;
            border-radius: 12px;
            border: 1px solid var(--admin-purple-soft);
        }

        /* ===== MAIN CONTENT WRAPPER ===== */
        .admin-main {
            margin-left: 260px;
            flex: 1;
            display: flex;
            flex-direction: column;
            min-height: 100vh;
            width: calc(100% - 260px);
            min-width: 0;
            transition: margin-left 0.3s ease, width 0.3s ease;
        }

        /* ===== TOPBAR HEADER ===== */
        .admin-topbar {
            background: #ffffff;
            padding: 14px 28px;
            border-bottom: 1px solid var(--admin-border);
            display: flex;
            justify-content: space-between;
            align-items: center;
            position: sticky;
            top: 0;
            z-index: 50;
            gap: 12px;
        }

        .admin-topbar-left {
            display: flex;
            align-items: center;
            gap: 12px;
            min-width: 0;
        }

        .admin-menu-toggle {
            display: none;
            background: #f1f5f9;
            border: 1px solid #e2e8f0;
            color: var(--admin-text-dark);
            width: 38px;
            height: 38px;
            border-radius: 10px;
            cursor: pointer;
            align-items: center;
            justify-content: center;
            font-size: 18px;
            flex-shrink: 0;
            transition: background 0.2s;
        }
        .admin-menu-toggle:hover {
            background: var(--admin-purple-soft);
            color: var(--admin-purple);
        }

        .admin-topbar-title {
            color: var(--admin-text-dark);
            font-size: 17px;
            font-weight: 700;
            font-family: 'Poppins', sans-serif;
            margin: 0;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
        }

        .admin-user-btn {
            display: flex;
            align-items: center;
            gap: 10px;
            background: none;
            border: none;
            cursor: pointer;
            padding: 4px 6px;
            border-radius: 10px;
            transition: background 0.2s;
        }
        .admin-user-btn:hover {
            background: #f8fafc;
        }

        .admin-user-name {
            font-size: 14px;
            color: #475569;
            font-weight: 600;
            white-space: nowrap;
        }

        .admin-avatar {
            width: 38px;
            height: 38px;
            background: var(--admin-purple-soft);
            color: var(--admin-purple);
            border-radius: 50%;
            overflow: hidden;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: bold;
            font-size: 14px;
            border: 1.5px solid var(--admin-purple-light);
            flex-shrink: 0;
        }

        /* ===== CONTENT BODY ===== */
        .admin-content {
            padding: 28px;
            flex: 1;
            min-width: 0;
        }

        /* ===== GLOBAL RESPONSIVE HELPERS FOR ADMIN PAGES ===== */
        .admin-card {
            background: white;
            padding: 24px;
            border-radius: 16px;
            border: 1px solid var(--admin-border);
            box-shadow: 0 4px 6px -1px rgba(0,0,0,0.02);
            margin-bottom: 24px;
        }

        .admin-grid-2 {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 20px;
        }

        .admin-grid-3 {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 20px;
        }

        .admin-grid-4 {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 20px;
        }

        .admin-dashboard-charts {
            display: grid;
            grid-template-columns: 1fr 1fr 2fr;
            gap: 20px;
            margin-bottom: 30px;
        }

        .admin-search-bar {
            display: flex;
            gap: 10px;
            margin-bottom: 20px;
            flex-wrap: wrap;
        }
        .admin-search-bar input {
            flex: 1;
            min-width: 200px;
        }

        .admin-table-container {
            overflow-x: auto;
            -webkit-overflow-scrolling: touch;
            width: 100%;
            border-radius: 12px;
        }

        /* ===================================================
           RESPONSIVE BREAKPOINTS (TABLET & MOBILE)
        =================================================== */
        @media (max-width: 1200px) {
            .admin-dashboard-charts {
                grid-template-columns: 1fr 1fr;
            }
            .admin-dashboard-charts > div:last-child {
                grid-column: 1 / -1;
            }
        }

        @media (max-width: 1024px) {
            .admin-sidebar {
                left: -290px;
                box-shadow: 4px 0 30px rgba(0,0,0,0.15);
            }
            .admin-sidebar.sidebar-open {
                left: 0;
            }
            .admin-sidebar-close {
                display: flex;
            }
            .admin-main {
                margin-left: 0;
                width: 100%;
            }
            .admin-menu-toggle {
                display: flex;
            }
            .admin-topbar {
                padding: 12px 18px;
            }
            .admin-content {
                padding: 20px 16px;
            }
            .admin-grid-4 {
                grid-template-columns: repeat(2, 1fr);
                gap: 14px;
            }
        }

        @media (max-width: 768px) {
            .admin-user-name {
                display: none;
            }
            .admin-topbar-title {
                font-size: 15px;
            }
            .admin-topbar {
                padding: 10px 14px;
            }
            .admin-content {
                padding: 16px 12px;
            }
            .admin-card {
                padding: 18px 14px;
            }
            .admin-grid-2,
            .admin-grid-3,
            .admin-grid-4 {
                grid-template-columns: 1fr;
                gap: 14px;
            }
            .admin-dashboard-charts {
                grid-template-columns: 1fr;
                gap: 16px;
            }
        }

        @media (max-width: 480px) {
            .admin-topbar-title {
                font-size: 14px;
            }
            .admin-content {
                padding: 14px 10px;
            }
        }
    </style>
</head>
<body>
    <div class="admin-layout">

        <!-- BACKDROP OVERLAY UNTUK MOBILE/TABLET -->
        <div class="admin-backdrop" id="adminSidebarOverlay" onclick="adminCloseSidebar()"></div>

        <!-- 1. SIDEBAR ADMIN (RESPONSIF MOBILE / DESKTOP) -->
        <aside class="admin-sidebar" id="adminSidebar">
            <div>
                <!-- Header Sidebar & Logo -->
                <div class="admin-sidebar-header">
                    <a href="{{ route('admin.dashboard') }}" class="admin-brand">
                        <img src="{{ asset('images/gitania-logo-admin.jpg') }}" alt="Gitania Skincare" style="width: 42px; height: 42px; object-fit: cover; border-radius: 12px; border: 1.5px solid #DDD6FE; box-shadow: 0 3px 10px rgba(107, 33, 168, 0.12); flex-shrink: 0;">
                        <div>
                            <div class="admin-brand-text">Gitania Skincare</div>
                            <div class="admin-brand-badge">Admin Workspace</div>
                        </div>
                    </a>
                    <!-- Tombol Tutup Sidebar (Mobile) -->
                    <button class="admin-sidebar-close" onclick="adminCloseSidebar()" aria-label="Tutup Menu">
                        ✕
                    </button>
                </div>

                <!-- Menu Navigation (Sidebar) -->
                <ul class="admin-nav">
                    <li>
                        <a href="{{ route('admin.dashboard') }}" class="admin-nav-link {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
                            <span>📊</span> Dashboard
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('admin.products.index') }}" class="admin-nav-link {{ request()->routeIs('admin.products*') ? 'active' : '' }}">
                            <span>📦</span> Kelola Produk
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('admin.orders.index') }}" class="admin-nav-link {{ request()->routeIs('admin.orders*') ? 'active' : '' }}">
                            <span>🛍️</span> Pesanan Masuk
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('admin.customers.index') }}" class="admin-nav-link {{ request()->routeIs('admin.customers*') ? 'active' : '' }}">
                            <span>👥</span> Kelola Pelanggan
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('admin.media.dashboard') }}" class="admin-nav-link {{ request()->routeIs('admin.media*') ? 'active' : '' }}">
                            <span>📸</span> Kelola Media
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('admin.media-posts.index') }}" class="admin-nav-link {{ request()->routeIs('admin.media-posts*') ? 'active' : '' }}">
                            <span>📰</span> Kelola Artikel
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('admin.banners.index') }}" class="admin-nav-link {{ request()->routeIs('admin.banners*') ? 'active' : '' }}">
                            <span>🖼️</span> Kelola Banner Slider
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('admin.before-after.index') }}" class="admin-nav-link {{ request()->routeIs('admin.before-after*') ? 'active' : '' }}">
                            <span>✨</span> Kelola Hasil Nyata (B/A)
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('admin.testimonials.index') }}" class="admin-nav-link {{ request()->routeIs('admin.testimonials*') ? 'active' : '' }}">
                            <span>💬</span> Kelola Ulasan Hasil
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('admin.settings') }}" class="admin-nav-link {{ request()->routeIs('admin.settings') ? 'active' : '' }}">
                            <span>⚙️</span> Pengaturan Akun
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('admin.reports.index') }}" class="admin-nav-link {{ request()->routeIs('admin.reports*') ? 'active' : '' }}">
                            <span>📈</span> Laporan & Ekspor
                        </a>
                    </li>
                </ul>
            </div>

            <!-- Info tambahan kecil di bawah sidebar -->
            <div class="admin-sidebar-footer">
                <p style="font-size: 12px; color: var(--admin-purple); font-weight: 700; margin: 0 0 2px 0;">Admin Panel Active</p>
                <p style="font-size: 11px; color: var(--admin-text-muted); margin: 0;">Gitania Skincare v1.2</p>
            </div>
        </aside>

        <!-- 2. KONTEN UTAMA & TOPBAR -->
        <div class="admin-main">

            <!-- Topbar Header -->
            <header class="admin-topbar">
                <div class="admin-topbar-left">
                    <!-- Tombol Hamburger Mobile -->
                    <button class="admin-menu-toggle" onclick="adminToggleSidebar()" aria-label="Buka Menu">
                        <svg width="20" height="20" fill="none" stroke="currentColor" stroke-width="2.2" viewBox="0 0 24 24">
                            <line x1="3" y1="6" x2="21" y2="6"/>
                            <line x1="3" y1="12" x2="21" y2="12"/>
                            <line x1="3" y1="18" x2="21" y2="18"/>
                        </svg>
                    </button>
                    <h2 class="admin-topbar-title">Panel Administrasi</h2>
                </div>

                <!-- Tombol Dark / Light Mode -->
                <button class="theme-toggle-btn" id="themeToggleBtn" onclick="adminToggleTheme()" title="Ganti Mode Tampilan">
                    <span id="themeIcon">🌙</span>
                    <span id="themeLabel">Mode Gelap</span>
                </button>

                <!-- Dropdown Profil Admin -->
                <div style="position: relative;" x-data="{ dropdownOpen: false }">
                    <button @click="dropdownOpen = !dropdownOpen" class="admin-user-btn">
                        <span class="admin-user-name">Halo, {{ auth()->user()->name ?? 'Admin Gitania' }}</span>
                        <div class="admin-avatar">
                            @if(auth()->user()->profile_photo ?? false)
                                <img src="{{ asset('storage/' . auth()->user()->profile_photo) }}" alt="Avatar" style="width: 100%; height: 100%; object-fit: cover;">
                            @else
                                {{ substr(auth()->user()->name ?? 'A', 0, 1) }}
                            @endif
                        </div>
                    </button>

                    <!-- Menu Dropdown -->
                    <div x-show="dropdownOpen" @click.away="dropdownOpen = false" style="position: absolute; right: 0; top: 48px; background: white; border: 1px solid #e2e8f0; box-shadow: 0 10px 25px rgba(0,0,0,0.1); border-radius: 12px; width: 190px; padding: 8px 0; z-index: 100; display: none;" x-transition>
                        <a href="{{ route('admin.settings') }}" style="display: flex; align-items: center; gap: 8px; padding: 10px 16px; color: #334155; text-decoration: none; font-size: 13px; font-weight: 500;">
                            <span>⚙️</span> Pengaturan Akun
                        </a>
                        <a href="{{ route('home') }}" target="_blank" style="display: flex; align-items: center; gap: 8px; padding: 10px 16px; color: #334155; text-decoration: none; font-size: 13px; font-weight: 500;">
                            <span>🌐</span> Lihat Toko Depan
                        </a>
                        <div style="height: 1px; background: #f1f5f9; margin: 4px 0;"></div>
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit" style="width: 100%; text-align: left; background: none; border: none; padding: 10px 16px; color: #ef4444; font-size: 13px; font-weight: 600; cursor: pointer; display: flex; align-items: center; gap: 8px;">
                                <span>🚪</span> Log Out
                            </button>
                        </form>
                    </div>
                </div>
            </header>

            <!-- Bagian Konten Dinamis -->
            <main class="admin-content">
                @yield('content')
            </main>

        </div>
    </div>

    <!-- Script Kontrol Sidebar Mobile -->
    <script>
        function adminToggleSidebar() {
            const sidebar = document.getElementById('adminSidebar');
            const overlay = document.getElementById('adminSidebarOverlay');
            if (!sidebar || !overlay) return;
            const isOpen = sidebar.classList.contains('sidebar-open');
            if (isOpen) {
                adminCloseSidebar();
            } else {
                sidebar.classList.add('sidebar-open');
                overlay.classList.add('active');
                document.body.style.overflow = 'hidden';
            }
        }

        function adminCloseSidebar() {
            const sidebar = document.getElementById('adminSidebar');
            const overlay = document.getElementById('adminSidebarOverlay');
            if (sidebar) sidebar.classList.remove('sidebar-open');
            if (overlay) overlay.classList.remove('active');
            document.body.style.overflow = '';
        }

        /* ─── DARK / LIGHT MODE ─── */
        (function () {
            const saved = localStorage.getItem('adminTheme');
            if (saved === 'dark') {
                document.documentElement.classList.add('dark-mode');
            }
        })();

        function adminToggleTheme() {
            const html   = document.documentElement;
            const icon   = document.getElementById('themeIcon');
            const label  = document.getElementById('themeLabel');
            const isDark = html.classList.toggle('dark-mode');

            if (isDark) {
                localStorage.setItem('adminTheme', 'dark');
                if (icon)  icon.textContent  = '☀️';
                if (label) label.textContent = 'Mode Terang';
            } else {
                localStorage.setItem('adminTheme', 'light');
                if (icon)  icon.textContent  = '🌙';
                if (label) label.textContent = 'Mode Gelap';
            }
        }

        /* Sesuaikan label tombol setelah load sesuai status saved */
        document.addEventListener('DOMContentLoaded', function () {
            const html  = document.documentElement;
            const icon  = document.getElementById('themeIcon');
            const label = document.getElementById('themeLabel');
            if (html.classList.contains('dark-mode')) {
                if (icon)  icon.textContent  = '☀️';
                if (label) label.textContent = 'Mode Terang';
            } else {
                if (icon)  icon.textContent  = '🌙';
                if (label) label.textContent = 'Mode Gelap';
            }
        });
    </script>
</body>
</html>
