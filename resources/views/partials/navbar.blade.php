{{-- ============================================================
     NAVBAR UTAMA — GITANIA SKINCARE
     Tema: Ungu & Putih | Responsif Mobile + Desktop
     ============================================================ --}}

<style>
    /* ===== NAVBAR BASE ===== */
    .gtn-navbar {
        background: #ffffff;
        border-bottom: 1px solid #ede9fe;
        box-shadow: 0 1px 12px rgba(107, 33, 168, 0.07);
        position: sticky;
        top: 0;
        z-index: 1000;
        width: 100%;
        box-sizing: border-box;
    }
    .gtn-navbar-inner {
        max-width: 1280px;
        margin: 0 auto;
        padding: 0 24px;
        height: 68px;
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 20px;
    }

    /* ===== LOGO ===== */
    .gtn-logo a {
        display: flex;
        align-items: center;
        text-decoration: none;
    }
    .gtn-logo img {
        height: 48px;
        width: auto;
        object-fit: contain;
    }

    /* ===== MENU DESKTOP ===== */
    .gtn-menu {
        display: flex;
        align-items: center;
        gap: 6px;
        list-style: none;
        margin: 0;
        padding: 0;
    }
    .gtn-menu a {
        text-decoration: none;
        color: #4B5563;
        font-size: 14px;
        font-weight: 500;
        padding: 7px 14px;
        border-radius: 8px;
        transition: background 0.2s, color 0.2s;
        white-space: nowrap;
    }
    .gtn-menu a:hover,
    .gtn-menu a.active {
        color: #6B21A8;
        background: #F5F3FF;
        font-weight: 600;
    }

    /* ===== AKSI KANAN ===== */
    .gtn-actions {
        display: flex;
        align-items: center;
        gap: 8px;
        flex-shrink: 0;
    }

    /* Tombol Keranjang */
    .gtn-cart-btn {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        background: #F5F3FF;
        color: #6B21A8;
        border: 1.5px solid #DDD6FE;
        padding: 7px 14px;
        border-radius: 999px;
        font-size: 13px;
        font-weight: 600;
        cursor: pointer;
        text-decoration: none;
        transition: background 0.2s, border-color 0.2s;
    }
    .gtn-cart-btn:hover {
        background: #EDE9FE;
        border-color: #7C3AED;
    }
    .gtn-cart-label { display: inline; }

    /* Tombol Akun */
    .gtn-account-btn {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        background: #6B21A8;
        color: #ffffff;
        padding: 7px 16px;
        border-radius: 999px;
        font-size: 13px;
        font-weight: 600;
        text-decoration: none;
        transition: background 0.2s;
        max-width: 160px;
    }
    .gtn-account-btn:hover { background: #581C87; }
    .gtn-account-btn span {
        overflow: hidden;
        text-overflow: ellipsis;
        white-space: nowrap;
    }
    .gtn-account-btn img {
        width: 18px; height: 18px;
        filter: brightness(0) invert(1);
    }
    .gtn-login-btn {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        background: #F5F3FF;
        color: #6B21A8;
        border: 1.5px solid #DDD6FE;
        padding: 7px 14px;
        border-radius: 999px;
        font-size: 13px;
        font-weight: 600;
        text-decoration: none;
        transition: background 0.2s;
    }
    .gtn-login-btn:hover { background: #EDE9FE; }
    .gtn-login-btn img {
        width: 18px; height: 18px;
    }

    /* ===== HAMBURGER ===== */
    .gtn-hamburger {
        display: none;
        background: none;
        border: none;
        cursor: pointer;
        padding: 6px;
        border-radius: 8px;
        color: #6B21A8;
        transition: background 0.2s;
    }
    .gtn-hamburger:hover { background: #F5F3FF; }
    .gtn-hamburger svg { display: block; }

    /* ===== MOBILE MENU DROPDOWN ===== */
    .gtn-mobile-menu {
        display: none;
        flex-direction: column;
        background: #ffffff;
        border-top: 1px solid #EDE9FE;
        padding: 12px 20px 16px 20px;
        gap: 4px;
        box-shadow: 0 6px 20px rgba(107, 33, 168, 0.07);
        position: sticky;
        top: 68px;
        z-index: 999;
    }
    .gtn-mobile-menu.open { display: flex; }
    .gtn-mobile-menu a {
        text-decoration: none;
        color: #4B5563;
        font-size: 14px;
        font-weight: 500;
        padding: 10px 14px;
        border-radius: 10px;
        transition: background 0.2s, color 0.2s;
    }
    .gtn-mobile-menu a:hover,
    .gtn-mobile-menu a.active {
        background: #F5F3FF;
        color: #6B21A8;
        font-weight: 600;
    }
    .gtn-mobile-divider {
        height: 1px;
        background: #EDE9FE;
        margin: 8px 0;
    }

    /* ===== RESPONSIVE BREAKPOINTS ===== */
    @media (max-width: 1024px) {
        .gtn-menu { display: none; }
        .gtn-hamburger { display: flex; align-items: center; justify-content: center; }
    }
    @media (max-width: 640px) {
        .gtn-navbar-inner { padding: 0 16px; height: 60px; }
        .gtn-mobile-menu { top: 60px; }
        .gtn-logo img { height: 40px; }
        .gtn-cart-label { display: none; }
        .gtn-cart-btn { padding: 7px 10px; }
        .gtn-account-btn span { display: none; }
        .gtn-account-btn { padding: 7px 10px; }
    }
</style>

{{-- ===== NAVBAR HTML ===== --}}
<nav class="gtn-navbar">
    <div class="gtn-navbar-inner">

        {{-- Logo --}}
        <div class="gtn-logo">
            <a href="{{ route('home') }}">
                <img src="{{ asset('images/logo-gitania.jpg') }}" alt="Gitania Skincare">
            </a>
        </div>

        {{-- Menu Desktop --}}
        <ul class="gtn-menu">
            <li><a href="{{ route('home') }}" class="{{ request()->routeIs('home') ? 'active' : '' }}">Home</a></li>
            <li><a href="{{ route('about') }}" class="{{ request()->routeIs('about') ? 'active' : '' }}">Tentang Kami</a></li>
            <li><a href="{{ route('shop.index') }}" class="{{ request()->routeIs('shop.*') ? 'active' : '' }}">Produk Kami</a></li>
            <li><a href="{{ route('home') }}#hasil-nyata">Before After</a></li>
            <li><a href="{{ route('media') }}" class="{{ request()->routeIs('media*') ? 'active' : '' }}">Media</a></li>
            <li><a href="{{ route('contact') }}" class="{{ request()->routeIs('contact') ? 'active' : '' }}">Kontak Kami</a></li>
        </ul>

        {{-- Aksi Kanan --}}
        <div class="gtn-actions">
            {{-- Keranjang --}}
            <a href="javascript:void(0);" onclick="toggleCart(); return false;" class="gtn-cart-btn" title="Keranjang">
                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round"><circle cx="9" cy="21" r="1"/><circle cx="20" cy="21" r="1"/><path d="M1 1h4l2.68 13.39a2 2 0 0 0 2 1.61h9.72a2 2 0 0 0 2-1.61L23 6H6"/></svg>
                <span class="gtn-cart-label">Keranjang</span>
            </a>

            {{-- Akun --}}
            @guest
                <a href="{{ route('login') }}" class="gtn-login-btn" title="Login">
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round"><path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"/><circle cx="12" cy="7" r="4"/></svg>
                    <span>Login</span>
                </a>
            @else
                <a href="{{ route('profile.index') }}" class="gtn-account-btn" title="Akun Saya">
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round" style="flex-shrink:0;"><path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"/><circle cx="12" cy="7" r="4"/></svg>
                    <span>{{ Auth::user()->name }}</span>
                </a>
            @endguest

            {{-- Hamburger --}}
            <button class="gtn-hamburger" onclick="toggleMobileNav()" id="gtn-hamburger-btn" aria-label="Menu">
                <svg id="gtn-icon-menu" xmlns="http://www.w3.org/2000/svg" width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round"><line x1="3" y1="6" x2="21" y2="6"/><line x1="3" y1="12" x2="21" y2="12"/><line x1="3" y1="18" x2="21" y2="18"/></svg>
                <svg id="gtn-icon-close" xmlns="http://www.w3.org/2000/svg" width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round" style="display:none;"><line x1="18" y1="6" x2="6" y2="18"/><line x1="6" y1="6" x2="18" y2="18"/></svg>
            </button>
        </div>
    </div>
</nav>

{{-- ===== MOBILE DROPDOWN MENU ===== --}}
<div class="gtn-mobile-menu" id="gtn-mobile-menu">
    <a href="{{ route('home') }}" class="{{ request()->routeIs('home') ? 'active' : '' }}">🏠 Home</a>
    <a href="{{ route('about') }}" class="{{ request()->routeIs('about') ? 'active' : '' }}">✨ Tentang Kami</a>
    <a href="{{ route('shop.index') }}" class="{{ request()->routeIs('shop.*') ? 'active' : '' }}">🛍️ Produk Kami</a>
    <a href="{{ route('home') }}#hasil-nyata">⭐ Before After</a>
    <a href="{{ route('media') }}" class="{{ request()->routeIs('media*') ? 'active' : '' }}">📸 Media</a>
    <a href="{{ route('contact') }}" class="{{ request()->routeIs('contact') ? 'active' : '' }}">📞 Kontak Kami</a>
    <div class="gtn-mobile-divider"></div>
    @guest
        <a href="{{ route('login') }}" style="background:#6B21A8; color:white; font-weight:600;">👤 Login / Daftar</a>
    @else
        <a href="{{ route('profile.index') }}">👤 Akun Saya — {{ Auth::user()->name }}</a>
        <a href="javascript:void(0);" onclick="toggleCart()">🛒 Buka Keranjang</a>
    @endguest
</div>

{{-- ===== CART SIDEBAR ===== --}}
<div id="cartOverlay" onclick="toggleCart()" style="position:fixed;top:0;left:0;width:100%;height:100%;background:rgba(0,0,0,0.45);backdrop-filter:blur(3px);display:none;z-index:9998;"></div>
<div id="cartSidebar" style="position:fixed;top:0;right:-100%;width:100%;max-width:420px;height:100%;background:#fff;z-index:9999;box-shadow:-8px 0 40px rgba(107,33,168,0.12);transition:right 0.35s cubic-bezier(0.16,1,0.3,1);display:flex;flex-direction:column;box-sizing:border-box;">
    <div id="cartDrawerContainer" style="display:flex;flex-direction:column;height:100%;">
        @php $cart = session()->get('cart', []); $subtotal = 0; @endphp

        {{-- Header --}}
        <div style="display:flex;justify-content:space-between;align-items:center;border-bottom:1px solid #EDE9FE;padding:20px 24px;background:#FAFAFA;">
            <div>
                <h3 style="margin:0;font-size:16px;font-weight:700;color:#1E1B4B;display:flex;align-items:center;gap:8px;">
                    <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="#6B21A8" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round"><circle cx="9" cy="21" r="1"/><circle cx="20" cy="21" r="1"/><path d="M1 1h4l2.68 13.39a2 2 0 0 0 2 1.61h9.72a2 2 0 0 0 2-1.61L23 6H6"/></svg>
                    Keranjang Belanja
                </h3>
                <span style="font-size:12px;color:#6B7280;margin-top:2px;display:block;">{{ count($cart) }} produk dipilih</span>
            </div>
            <button onclick="toggleCart()" style="background:#F5F3FF;border:none;width:34px;height:34px;border-radius:50%;font-size:14px;cursor:pointer;color:#6B21A8;font-weight:bold;display:flex;align-items:center;justify-content:center;border:1.5px solid #DDD6FE;">✕</button>
        </div>

        {{-- List Produk --}}
        <div style="padding:16px 24px;flex:1;overflow-y:auto;max-height:calc(100vh - 200px);">
            @forelse($cart as $id => $item)
                @php $itemTotal = $item['price'] * $item['quantity']; $subtotal += $itemTotal; @endphp
                <div style="display:flex;align-items:center;gap:14px;padding-bottom:16px;margin-bottom:16px;border-bottom:1px solid #F5F3FF;">
                    <img src="{{ $item['image'] }}" style="width:64px;height:64px;object-fit:cover;border-radius:12px;border:1px solid #EDE9FE;flex-shrink:0;">
                    <div style="flex:1;min-width:0;">
                        <h4 style="margin:0 0 4px 0;font-size:13px;font-weight:600;color:#1E1B4B;line-height:1.3;overflow:hidden;text-overflow:ellipsis;white-space:nowrap;">{{ $item['name'] }}</h4>
                        <div style="color:#6B21A8;font-size:13px;font-weight:700;margin-bottom:8px;">Rp{{ number_format($item['price'], 0, ',', '.') }}</div>
                        <div style="display:inline-flex;align-items:center;border:1.5px solid #DDD6FE;border-radius:8px;overflow:hidden;background:white;">
                            <button type="button" onclick="updateCartQty('{{ $id }}', -1)" style="padding:4px 12px;background:none;border:none;cursor:pointer;font-weight:bold;color:#6B21A8;font-size:16px;">−</button>
                            <span style="padding:4px 10px;font-size:13px;font-weight:600;min-width:18px;text-align:center;color:#1E1B4B;">{{ $item['quantity'] }}</span>
                            <button type="button" onclick="updateCartQty('{{ $id }}', 1)" style="padding:4px 12px;background:none;border:none;cursor:pointer;font-weight:bold;color:#6B21A8;font-size:16px;">+</button>
                        </div>
                    </div>
                    <button onclick="removeCartItem('{{ $id }}')" style="background:none;border:none;color:#9CA3AF;cursor:pointer;font-size:18px;padding:4px;flex-shrink:0;" title="Hapus">🗑️</button>
                </div>
            @empty
                <div style="text-align:center;color:#6B7280;padding:50px 0;">
                    <div style="font-size:40px;margin-bottom:12px;">🛒</div>
                    <p style="font-size:14px;font-weight:500;margin:0;">Keranjang belanja masih kosong.</p>
                    <a href="{{ route('shop.index') }}" style="display:inline-block;margin-top:16px;color:#6B21A8;font-weight:600;font-size:13px;">Mulai belanja →</a>
                </div>
            @endforelse
        </div>

        {{-- Footer --}}
        <div style="border-top:1px solid #EDE9FE;padding:20px 24px;background:#FAFAFA;">
            <div style="display:flex;justify-content:space-between;font-weight:700;font-size:15px;margin-bottom:14px;color:#1E1B4B;">
                <span>Total</span>
                <span style="color:#6B21A8;">Rp{{ number_format($subtotal, 0, ',', '.') }}</span>
            </div>
            <button onclick="gtnOpenCheckoutModal()" style="display:block;text-align:center;width:100%;padding:14px;background:linear-gradient(135deg,#8B5CF6,#6B21A8);color:white;border-radius:12px;text-decoration:none;font-weight:700;font-size:14px;margin-bottom:10px;box-sizing:border-box;transition:opacity 0.2s;border:none;cursor:pointer;font-family:inherit;" onmouseover="this.style.opacity='0.9'" onmouseout="this.style.opacity='1'">
                Proses Pembayaran →
            </button>
            <button onclick="toggleCart()" style="width:100%;padding:13px;background:white;border:1.5px solid #DDD6FE;color:#6B21A8;border-radius:12px;font-weight:600;font-size:14px;cursor:pointer;transition:background 0.2s;" onmouseover="this.style.background='#F5F3FF'" onmouseout="this.style.background='white'">
                Lanjut Belanja
            </button>
        </div>
    </div>
</div>

{{-- ===== MODAL PILIHAN CHECKOUT (di luar cartDrawerContainer, tidak kena replace AJAX) ===== --}}
<div id="gtnCheckoutModal" style="display:none;position:fixed;inset:0;z-index:99999;align-items:center;justify-content:center;">
    <div onclick="gtnCloseCheckoutModal()" style="position:absolute;inset:0;background:rgba(79,38,143,0.35);backdrop-filter:blur(4px);"></div>
    <div style="position:relative;background:white;border-radius:24px;padding:32px 28px;width:340px;max-width:calc(100vw - 32px);box-shadow:0 24px 60px rgba(109,40,217,0.22);z-index:1;text-align:center;">
        <button onclick="gtnCloseCheckoutModal()" style="position:absolute;top:14px;right:14px;background:#F5F3FF;border:none;width:32px;height:32px;border-radius:50%;cursor:pointer;font-size:13px;color:#7C3AED;display:flex;align-items:center;justify-content:center;font-weight:bold;">✕</button>
        <div style="font-size:38px;margin-bottom:10px;">🛒</div>
        <h3 style="margin:0 0 6px;font-size:18px;font-weight:800;color:#1a162b;font-family:'Poppins',sans-serif;">Pilih Tempat Pembelian</h3>
        <p style="margin:0 0 24px;font-size:13px;color:#665c75;line-height:1.6;">Beli langsung di website kami<br>atau via marketplace favoritmu!</p>

        {{-- Opsi 1: Website --}}
        <a href="{{ route('cart.index') }}" style="display:flex;align-items:center;gap:14px;padding:14px 18px;border:2px solid #DDD6FE;border-radius:14px;text-decoration:none;margin-bottom:12px;background:#FAFAFE;transition:all 0.2s;" onmouseover="this.style.borderColor='#8B5CF6';this.style.background='#F5F3FF'" onmouseout="this.style.borderColor='#DDD6FE';this.style.background='#FAFAFE'">
            <div style="width:44px;height:44px;background:linear-gradient(135deg,#8B5CF6,#7C3AED);border-radius:12px;display:flex;align-items:center;justify-content:center;flex-shrink:0;">
                <svg width="22" height="22" fill="none" stroke="white" stroke-width="2" viewBox="0 0 24 24"><path d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.3 2.3c-.63.63-.18 1.7.7 1.7H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z"/></svg>
            </div>
            <div style="text-align:left;flex:1;">
                <div style="font-weight:700;font-size:14px;color:#1a162b;">Website Gitania</div>
                <div style="font-size:11.5px;color:#8B5CF6;font-weight:500;">Checkout langsung &amp; aman 🔒</div>
            </div>
            <svg width="16" height="16" fill="none" stroke="#8B5CF6" stroke-width="2.5" viewBox="0 0 24 24"><polyline points="9 18 15 12 9 6"/></svg>
        </a>

        <div style="display:flex;align-items:center;gap:10px;margin-bottom:12px;">
            <div style="flex:1;height:1px;background:#EDE9FE;"></div>
            <span style="font-size:11px;color:#9CA3AF;font-weight:600;">atau beli di marketplace</span>
            <div style="flex:1;height:1px;background:#EDE9FE;"></div>
        </div>

        {{-- Opsi 2: Shopee --}}
        <a href="https://shopee.co.id/gitafajar2011?categoryId=100630&entryPoint=ShopByPDP&itemId=25591877640" target="_blank" rel="noopener noreferrer" style="display:flex;align-items:center;gap:14px;padding:14px 18px;border:2px solid #FFDDD6;border-radius:14px;text-decoration:none;margin-bottom:12px;background:#FFF8F6;transition:all 0.2s;" onmouseover="this.style.borderColor='#EE4D2D';this.style.background='#FFF1EE'" onmouseout="this.style.borderColor='#FFDDD6';this.style.background='#FFF8F6'">
            <img src="{{ asset('images/logo-shopee.jpg') }}" alt="Shopee" style="width:44px;height:44px;object-fit:contain;border-radius:10px;background:white;padding:4px;border:1px solid #FFDDD6;flex-shrink:0;">
            <div style="text-align:left;flex:1;">
                <div style="font-weight:700;font-size:14px;color:#1a162b;">Shopee</div>
                <div style="font-size:11.5px;color:#EE4D2D;font-weight:500;">Beli di Shopee Official Store 🛍️</div>
            </div>
            <svg width="16" height="16" fill="none" stroke="#EE4D2D" stroke-width="2.5" viewBox="0 0 24 24"><polyline points="9 18 15 12 9 6"/></svg>
        </a>

        {{-- Opsi 3: Tokopedia (coming soon) --}}
        <div style="display:flex;align-items:center;gap:14px;padding:14px 18px;border:2px solid #D4EDDA;border-radius:14px;background:#F4FDF6;opacity:0.6;cursor:not-allowed;">
            <img src="{{ asset('images/logo-tokopedia.png') }}" alt="Tokopedia" style="width:44px;height:44px;object-fit:contain;border-radius:10px;background:white;padding:4px;border:1px solid #D4EDDA;flex-shrink:0;">
            <div style="text-align:left;flex:1;">
                <div style="font-weight:700;font-size:14px;color:#1a162b;">Tokopedia</div>
                <div style="font-size:11.5px;color:#00AA5B;font-weight:500;">Segera hadir! 🔜</div>
            </div>
            <span style="background:#E8F5E9;color:#00AA5B;font-size:10px;font-weight:700;padding:3px 10px;border-radius:20px;white-space:nowrap;">Coming Soon</span>
        </div>
    </div>
</div>

<script>
    function toggleMobileNav() {
        const menu = document.getElementById('gtn-mobile-menu');
        const iconMenu = document.getElementById('gtn-icon-menu');
        const iconClose = document.getElementById('gtn-icon-close');
        const isOpen = menu.classList.contains('open');
        menu.classList.toggle('open');
        iconMenu.style.display = isOpen ? 'block' : 'none';
        iconClose.style.display = isOpen ? 'none' : 'block';
    }

    function toggleCart() {
        const sidebar = document.getElementById('cartSidebar');
        const overlay = document.getElementById('cartOverlay');
        const isOpen = sidebar.style.right === '0px';
        sidebar.style.right = isOpen ? '-100%' : '0px';
        overlay.style.display = isOpen ? 'none' : 'block';
        if (!isOpen) refreshCartDrawer();
    }

    function refreshCartDrawer() {
        fetch("{{ route('cart.data') }}")
            .then(r => r.json())
            .then(data => { document.getElementById('cartDrawerContainer').innerHTML = data.html; })
            .catch(e => console.error('Error:', e));
    }

    function updateCartQty(productId, change) {
        const fd = new FormData();
        fd.append('product_id', productId);
        fd.append('change', change);
        fd.append('_token', '{{ csrf_token() }}');
        fetch("{{ route('cart.update') }}", { method: 'POST', body: fd })
            .then(r => r.json())
            .then(data => { if (data.success) document.getElementById('cartDrawerContainer').innerHTML = data.html; });
    }

    function removeCartItem(productId) {
        const fd = new FormData();
        fd.append('product_id', productId);
        fd.append('_token', '{{ csrf_token() }}');
        fetch("{{ route('cart.ajax.remove') }}", { method: 'POST', body: fd })
            .then(r => r.json())
            .then(data => { if (data.success) document.getElementById('cartDrawerContainer').innerHTML = data.html; });
    }

    function gtnOpenCheckoutModal() {
        var m = document.getElementById('gtnCheckoutModal');
        if (m) { m.style.display = 'flex'; document.body.style.overflow = 'hidden'; }
    }

    function gtnCloseCheckoutModal() {
        var m = document.getElementById('gtnCheckoutModal');
        if (m) { m.style.display = 'none'; document.body.style.overflow = ''; }
    }

    document.addEventListener('keydown', function(e) {
        if (e.key === 'Escape') gtnCloseCheckoutModal();
    });
</script>
