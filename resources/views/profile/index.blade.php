<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Profil Saya — Gitania Skincare</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        :root {
            --primary: #6B21A8;
            --primary-dark: #581C87;
            --primary-pale: #F5F3FF;
            --primary-soft: #EDE9FE;
            --primary-border: #DDD6FE;
            --white: #FFFFFF;
            --bg: #FAFAFA;
            --text-dark: #1E1B4B;
            --text-muted: #6B7280;
            /* Legacy */
            --purple-deep: #6B21A8;
            --lilac-soft: #EDE9FE;
            --lilac-light: #F5F3FF;
            --accent-pink: #7C3AED;
        }
        *, *::before, *::after { box-sizing: border-box; }
        body { font-family: 'Poppins', sans-serif; margin: 0; background: var(--bg); color: #374151; overflow-x: hidden; }

        /* ===== LAYOUT ===== */
        .profile-wrapper {
            max-width: 1150px;
            margin: 40px auto 80px auto;
            padding: 0 24px;
            display: flex;
            gap: 28px;
            align-items: flex-start;
        }

        /* ===== SIDEBAR ===== */
        .profile-sidebar {
            width: 270px;
            flex-shrink: 0;
            background: white;
            border-radius: 20px;
            border: 1px solid var(--primary-soft);
            box-shadow: 0 4px 20px rgba(107,33,168,0.05);
            padding: 24px;
            position: sticky;
            top: 80px;
        }
        .profile-avatar {
            width: 58px; height: 58px;
            background: var(--primary-pale);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 22px;
            font-weight: 800;
            color: var(--primary);
            border: 2px solid var(--primary-border);
            flex-shrink: 0;
        }
        .sidebar-nav { display: flex; flex-direction: column; gap: 4px; }
        .sidebar-nav-link {
            display: flex;
            align-items: center;
            gap: 10px;
            padding: 11px 14px;
            border-radius: 12px;
            text-decoration: none;
            color: var(--text-muted);
            font-size: 14px;
            font-weight: 500;
            transition: background 0.2s, color 0.2s;
        }
        .sidebar-nav-link:hover { background: var(--primary-pale); color: var(--primary); }
        .sidebar-nav-link.active {
            background: var(--primary-pale);
            color: var(--primary);
            font-weight: 700;
            border-left: 3px solid var(--primary);
        }
        .sidebar-nav-icon { width: 20px; text-align: center; flex-shrink: 0; }

        /* ===== MAIN CONTENT ===== */
        .profile-main { flex: 1; min-width: 0; }

        /* ===== CONTENT BOX ===== */
        .profile-box {
            background: white;
            border-radius: 20px;
            border: 1px solid var(--primary-soft);
            box-shadow: 0 4px 18px rgba(107,33,168,0.05);
            padding: 28px;
        }
        .profile-box-title {
            font-size: 17px;
            font-weight: 700;
            color: var(--text-dark);
            margin-bottom: 20px;
            padding-bottom: 14px;
            border-bottom: 1px solid var(--primary-soft);
            display: flex;
            align-items: center;
            gap: 10px;
        }

        /* ===== STATUS BADGE ===== */
        .order-status {
            font-size: 11px;
            padding: 4px 10px;
            border-radius: 999px;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 0.4px;
        }
        .status-completed { background: #DCFCE7; color: #166534; }
        .status-pending { background: #FEF9C3; color: #854D0E; }
        .status-processing { background: #DBEAFE; color: #1E40AF; }
        .status-cancelled { background: #FEE2E2; color: #991B1B; }

        /* ===== ORDER CARD ===== */
        .order-card {
            border: 1px solid var(--primary-soft);
            border-radius: 14px;
            padding: 18px 20px;
            margin-bottom: 14px;
            background: #FAFAFA;
            transition: border-color 0.2s;
        }
        .order-card:hover { border-color: var(--primary-border); }
        .order-card:last-child { margin-bottom: 0; }

        /* ===== STAT BOXES ===== */
        .stat-boxes {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 14px;
            margin-bottom: 22px;
        }
        .stat-box {
            background: var(--primary-pale);
            border-radius: 14px;
            padding: 18px 12px;
            text-align: center;
            border: 1px solid var(--primary-soft);
            transition: transform 0.2s;
        }
        .stat-box:hover { transform: translateY(-2px); }
        .stat-box-icon { font-size: 24px; margin-bottom: 8px; }
        .stat-box-label { font-size: 12px; font-weight: 600; color: var(--primary); }

        /* ===== FORM ===== */
        .form-group { margin-bottom: 16px; }
        .form-label {
            font-size: 12px; font-weight: 700;
            color: var(--text-dark); display: block;
            margin-bottom: 7px; text-transform: uppercase; letter-spacing: 0.5px;
        }
        .form-input {
            width: 100%; padding: 12px 14px;
            border: 1.5px solid #E5E7EB;
            border-radius: 10px; font-family: 'Poppins', sans-serif;
            font-size: 13px; outline: none;
            transition: border-color 0.2s, box-shadow 0.2s;
            color: var(--text-dark); background: white;
        }
        .form-input:focus {
            border-color: var(--primary);
            box-shadow: 0 0 0 3px rgba(107,33,168,0.08);
        }
        .form-input:disabled { background: #F9FAFB; color: var(--text-muted); }

        /* Mobile sidebar toggle */
        .sidebar-toggle-btn {
            display: none;
            align-items: center;
            gap: 8px;
            background: white;
            border: 1.5px solid var(--primary-border);
            color: var(--primary);
            padding: 10px 18px;
            border-radius: 10px;
            font-family: 'Poppins', sans-serif;
            font-size: 13px;
            font-weight: 600;
            cursor: pointer;
            margin-bottom: 16px;
            width: 100%;
            justify-content: center;
        }

        /* ===== RESPONSIVE ===== */
        @media (max-width: 900px) {
            .stat-boxes { grid-template-columns: repeat(2, 1fr); }
        }
        @media (max-width: 768px) {
            .profile-wrapper { flex-direction: column; padding: 0 16px; margin-top: 24px; gap: 16px; }
            .profile-sidebar { width: 100%; position: static; display: none; }
            .profile-sidebar.open { display: block; }
            .sidebar-toggle-btn { display: flex; }
        }
        @media (max-width: 480px) {
            .stat-boxes { grid-template-columns: repeat(2, 1fr); }
            .profile-box { padding: 20px 16px; }
        }
    </style>
</head>
<body>
    @include('partials.navbar')

    <!-- Mobile Sidebar Toggle -->
    <div style="max-width: 1150px; margin: 20px auto 0 auto; padding: 0 16px;">
        <button class="sidebar-toggle-btn" onclick="toggleProfileSidebar()">
            👤 Menu Akun ▼
        </button>
    </div>

    <div class="profile-wrapper">

        <!-- ===== SIDEBAR KIRI ===== -->
        <aside class="profile-sidebar" id="profileSidebar">

            <!-- Avatar & Nama -->
            <div style="display: flex; align-items: center; gap: 14px; margin-bottom: 24px; padding-bottom: 20px; border-bottom: 1px solid var(--primary-soft);">
                <div class="profile-avatar">
                    {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
                </div>
                <div>
                    <div style="font-weight: 700; font-size: 15px; color: var(--text-dark); margin-bottom: 2px;">{{ Auth::user()->name }}</div>
                    <a href="{{ route('profile.index', ['tab' => 'edit']) }}" style="font-size: 12px; color: var(--primary); text-decoration: none; font-weight: 600;">✏️ Edit Profil</a>
                </div>
            </div>

            <!-- Navigasi -->
            <nav class="sidebar-nav">
                <a href="{{ route('profile.index', ['tab' => 'overview']) }}"
                   class="sidebar-nav-link {{ $tab == 'overview' ? 'active' : '' }}">
                    <span class="sidebar-nav-icon">👤</span> Akun Saya
                </a>
                <a href="{{ route('profile.index', ['tab' => 'orders']) }}"
                   class="sidebar-nav-link {{ $tab == 'orders' ? 'active' : '' }}">
                    <span class="sidebar-nav-icon">📦</span> Pesanan Saya
                </a>
                <a href="{{ route('profile.index', ['tab' => 'addresses']) }}"
                   class="sidebar-nav-link {{ in_array($tab, ['addresses', 'address-create']) ? 'active' : '' }}">
                    <span class="sidebar-nav-icon">📍</span> Alamat Pengiriman
                </a>
            </nav>

            <!-- Logout -->
            <div style="margin-top: 28px; padding-top: 20px; border-top: 1px solid var(--primary-soft);">
                <form action="{{ route('logout') }}" method="POST">
                    @csrf
                    <button type="submit" style="width: 100%; background: #FEF2F2; color: #DC2626; border: none; padding: 11px 14px; border-radius: 12px; font-size: 13px; font-weight: 600; cursor: pointer; text-align: left; font-family: 'Poppins', sans-serif; display: flex; align-items: center; gap: 8px; transition: background 0.2s;" onmouseover="this.style.background='#FEE2E2'" onmouseout="this.style.background='#FEF2F2'">
                        🚪 Log Out
                    </button>
                </form>
            </div>

        </aside>

        <!-- ===== KONTEN UTAMA ===== -->
        <div class="profile-main">

            {{-- ===== TAB: AKUN SAYA ===== --}}
            @if($tab == 'overview')
                <div class="profile-box">
                    <div class="profile-box-title">📦 Status Pesanan Saya</div>
                    <div class="stat-boxes">
                        <div class="stat-box">
                            <div class="stat-box-icon">⏳</div>
                            <div class="stat-box-label">Belum Bayar</div>
                        </div>
                        <div class="stat-box">
                            <div class="stat-box-icon">📦</div>
                            <div class="stat-box-label">Dikemas</div>
                        </div>
                        <div class="stat-box">
                            <div class="stat-box-icon">🚚</div>
                            <div class="stat-box-label">Dikirim</div>
                        </div>
                        <div class="stat-box">
                            <div class="stat-box-icon">⭐</div>
                            <div class="stat-box-label">Terkirim</div>
                        </div>
                    </div>
                    <div style="text-align: center; padding: 10px 0 0 0;">
                        <a href="{{ route('profile.index', ['tab' => 'orders']) }}"
                           style="color: var(--primary); font-weight: 600; font-size: 14px; text-decoration: none;">
                            Lihat Riwayat Pesanan →
                        </a>
                    </div>
                </div>

            {{-- ===== TAB: EDIT PROFIL ===== --}}
            @elseif($tab == 'edit')
                <div class="profile-box">
                    <div class="profile-box-title">👤 Informasi Pribadi</div>
                    <form action="{{ route('profile.update') }}" method="POST">
                        @csrf
                        @method('PATCH')
                        <div class="form-group">
                            <label class="form-label">Nama Lengkap *</label>
                            <input type="text" name="name" value="{{ Auth::user()->name }}" class="form-input" required>
                        </div>
                        <div class="form-group">
                            <label class="form-label">Email</label>
                            <input type="email" value="{{ Auth::user()->email }}" class="form-input" disabled>
                            <p style="font-size: 11px; color: var(--text-muted); margin: 6px 0 0 0;">Email tidak dapat diubah</p>
                        </div>
                        <button type="submit" class="btn-primary" style="width: 100%; justify-content: center; border-radius: 12px; padding: 13px; font-size: 14px; margin-top: 8px;">
                            💾 Simpan Perubahan
                        </button>
                    </form>
                </div>

            {{-- ===== TAB: PESANAN SAYA ===== --}}
            @elseif($tab == 'orders')
                <div class="profile-box">
                    <div class="profile-box-title">📦 Riwayat Transaksi</div>

                    @php
                        $orders = \App\Models\Order::where('customer_phone', Auth::user()->phone ?? '')
                                    ->orWhere('customer_name', Auth::user()->name)
                                    ->latest()
                                    ->get();
                    @endphp

                    @if($orders->count() > 0)
                        @foreach($orders as $order)
                            <div class="order-card">
                                <div style="display: flex; justify-content: space-between; align-items: flex-start; flex-wrap: wrap; gap: 8px; margin-bottom: 10px;">
                                    <div>
                                        <div style="font-weight: 700; font-size: 14px; color: var(--text-dark);">{{ $order->invoice_number }}</div>
                                        <div style="font-size: 12px; color: var(--text-muted); margin-top: 2px;">{{ $order->created_at->format('d M Y') }}</div>
                                    </div>
                                    <span class="order-status status-{{ $order->status }}">
                                        {{ ucwords($order->status) }}
                                    </span>
                                </div>

                                <div style="font-size: 14px; font-weight: 700; color: var(--primary); margin-bottom: 6px;">
                                    Rp{{ number_format($order->total_amount, 0, ',', '.') }}
                                </div>

                                @if(!empty($order->tracking_number))
                                    <div style="font-size: 12px; color: var(--text-muted); margin-bottom: 10px;">
                                        🚚 No. Resi: <strong style="color: var(--text-dark);">{{ $order->tracking_number }}</strong>
                                    </div>
                                @endif

                                @if($order->status == 'completed')
                                    <div style="display: flex; justify-content: flex-end; gap: 10px; align-items: center; border-top: 1px solid var(--primary-soft); padding-top: 12px; margin-top: 10px; flex-wrap: wrap;">
                                        <form action="{{ route('cart.add') }}" method="POST" style="margin: 0;">
                                            @csrf
                                            <input type="hidden" name="product_id" value="{{ $order->product_id }}">
                                            <input type="hidden" name="quantity" value="{{ $order->quantity ?? 1 }}">
                                            <button type="submit" style="background: white; color: var(--primary); border: 1.5px solid var(--primary-border); padding: 7px 16px; border-radius: 8px; font-size: 13px; font-weight: 600; cursor: pointer; font-family: 'Poppins', sans-serif; transition: background 0.2s;" onmouseover="this.style.background='var(--primary-pale)'" onmouseout="this.style.background='white'">
                                                🛒 Beli Lagi
                                            </button>
                                        </form>

                                        @php $hasReviewed = \App\Models\Review::where('order_id', $order->id)->exists(); @endphp
                                        @if(!$hasReviewed)
                                            <a href="{{ route('user.reviews.create', $order->id) }}"
                                               style="background: var(--primary); color: white; text-decoration: none; padding: 7px 16px; border-radius: 8px; font-size: 13px; font-weight: 600; transition: background 0.2s;" onmouseover="this.style.background='var(--primary-dark)'" onmouseout="this.style.background='var(--primary)'">
                                                ⭐ Beri Ulasan
                                            </a>
                                        @else
                                            <span style="color: #16A34A; font-size: 13px; font-weight: 600;">✅ Sudah Diulas</span>
                                        @endif
                                    </div>
                                @endif
                            </div>
                        @endforeach
                    @else
                        <div style="text-align: center; padding: 50px 20px;">
                            <div style="font-size: 48px; margin-bottom: 12px;">🛍️</div>
                            <h3 style="color: var(--text-dark); font-size: 16px; margin: 0 0 6px 0;">Belum ada pesanan</h3>
                            <p style="color: var(--text-muted); font-size: 13px; margin: 0 0 20px 0;">Pesanan kamu akan muncul di sini setelah melakukan pembelian.</p>
                            <a href="{{ route('shop.index') }}" class="btn-primary" style="display: inline-flex; padding: 10px 24px; border-radius: 10px; font-size: 13px;">Mulai Belanja →</a>
                        </div>
                    @endif
                </div>

            {{-- ===== TAB: ALAMAT ===== --}}
            @elseif($tab == 'addresses')
                <div class="profile-box">
                    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px; padding-bottom: 14px; border-bottom: 1px solid var(--primary-soft); flex-wrap: wrap; gap: 10px;">
                        <div class="profile-box-title" style="margin: 0; border: none; padding: 0;">📍 Alamat Pengiriman</div>
                        <a href="{{ route('profile.index', ['tab' => 'address-create']) }}"
                           style="background: var(--primary); color: white; text-decoration: none; padding: 8px 18px; border-radius: 10px; font-size: 13px; font-weight: 600; transition: background 0.2s;" onmouseover="this.style.background='var(--primary-dark)'" onmouseout="this.style.background='var(--primary)'">
                            + Tambah Alamat
                        </a>
                    </div>
                    <div style="text-align: center; padding: 50px 20px;">
                        <div style="font-size: 48px; margin-bottom: 12px;">📍</div>
                        <h3 style="color: var(--text-dark); font-size: 16px; margin: 0 0 6px 0;">Belum ada alamat tersimpan</h3>
                        <p style="color: var(--text-muted); font-size: 13px; margin: 0 0 20px 0;">Tambahkan alamat untuk memudahkan proses checkout.</p>
                        <a href="{{ route('profile.index', ['tab' => 'address-create']) }}"
                           style="background: var(--primary); color: white; text-decoration: none; padding: 10px 24px; border-radius: 10px; font-size: 14px; font-weight: 600; display: inline-block;">
                            + Tambah Alamat Pertama
                        </a>
                    </div>
                </div>

            {{-- ===== TAB: TAMBAH ALAMAT ===== --}}
            @elseif($tab == 'address-create')
                <div class="profile-box">
                    <div style="display: flex; align-items: center; gap: 10px; margin-bottom: 20px; padding-bottom: 14px; border-bottom: 1px solid var(--primary-soft);">
                        <a href="{{ route('profile.index', ['tab' => 'addresses']) }}"
                           style="width: 32px; height: 32px; background: var(--primary-pale); border-radius: 8px; display: flex; align-items: center; justify-content: center; text-decoration: none; color: var(--primary); font-weight: 700; border: 1px solid var(--primary-border);">
                            ←
                        </a>
                        <div class="profile-box-title" style="margin: 0; border: none; padding: 0;">Tambah Alamat Baru</div>
                    </div>
                    <form action="#" method="POST">
                        @csrf
                        <div class="form-group">
                            <label class="form-label">Nama Lokasi *</label>
                            <input type="text" placeholder="Contoh: Rumah / Kantor" class="form-input">
                        </div>
                        <button type="submit" class="btn-primary" style="width: 100%; justify-content: center; border-radius: 12px; padding: 13px; font-size: 14px; margin-top: 4px;">
                            💾 Simpan Alamat
                        </button>
                    </form>
                </div>

            @endif
        </div>

    </div>

    @include('partials.footer')
    @include('partials.chatbot')

    <script>
        function toggleProfileSidebar() {
            const sidebar = document.getElementById('profileSidebar');
            sidebar.classList.toggle('open');
        }
    </script>

    <style>
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
            font-family: 'Poppins', sans-serif;
            transition: background 0.2s;
        }
        .btn-primary:hover { background: var(--primary-dark); }
    </style>
</body>
</html>
