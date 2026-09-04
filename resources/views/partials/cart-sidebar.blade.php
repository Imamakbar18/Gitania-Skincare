<div id="cartSidebar" style="position: fixed; top:0; right:-420px; width: 400px; height: 100%; background: white; z-index: 9999; box-shadow: -8px 0 32px rgba(109,40,217,0.13); transition: right 0.3s cubic-bezier(0.4,0,0.2,1); display: flex; flex-direction: column; overflow: hidden;">
    <div id="cartContent" style="display: flex; flex-direction: column; height: 100%;">
        <!-- Data keranjang akan muncul di sini via AJAX -->
    </div>
</div>

<!-- Overlay Keranjang -->
<div id="cartOverlay" onclick="toggleCart()" style="position: fixed; top:0; left:0; width:100%; height:100%; background:rgba(79,38,143,0.25); backdrop-filter: blur(2px); display:none; z-index:9998;"></div>

<!-- ====================================================
     MODAL PILIHAN CHECKOUT (selalu di DOM, bukan AJAX)
     ==================================================== -->
<div id="gtnCheckoutModal" style="display:none; position:fixed; inset:0; z-index:99999; align-items:center; justify-content:center;">
    <!-- Backdrop -->
    <div onclick="gtnCloseCheckoutModal()" style="position:absolute; inset:0; background:rgba(79,38,143,0.35); backdrop-filter:blur(4px);"></div>

    <!-- Modal Box -->
    <div style="position:relative; background:white; border-radius:24px; padding:32px 28px; width:340px; max-width:calc(100vw - 32px); box-shadow:0 24px 60px rgba(109,40,217,0.22); z-index:1; text-align:center;">

        <!-- Close button -->
        <button onclick="gtnCloseCheckoutModal()" style="position:absolute; top:14px; right:14px; background:#F5F3FF; border:none; width:32px; height:32px; border-radius:50%; cursor:pointer; font-size:13px; color:#7C3AED; display:flex; align-items:center; justify-content:center; font-weight:bold;">✕</button>

        <!-- Icon & Judul -->
        <div style="font-size:38px; margin-bottom:10px;">🛒</div>
        <h3 style="margin:0 0 6px; font-size:18px; font-weight:800; color:#1a162b; font-family:'Poppins',sans-serif;">Pilih Tempat Pembelian</h3>
        <p style="margin:0 0 24px; font-size:13px; color:#665c75; line-height:1.6;">Beli langsung di website kami<br>atau via marketplace favoritmu!</p>

        <!-- Opsi 1: Website (Checkout Langsung) -->
        <a href="/cart" style="display:flex; align-items:center; gap:14px; padding:14px 18px; border:2px solid #DDD6FE; border-radius:14px; text-decoration:none; margin-bottom:12px; background:#FAFAFE; transition:all 0.2s;"
            onmouseover="this.style.borderColor='#8B5CF6';this.style.background='#F5F3FF'"
            onmouseout="this.style.borderColor='#DDD6FE';this.style.background='#FAFAFE'"
        >
            <div style="width:44px; height:44px; background:linear-gradient(135deg,#8B5CF6,#7C3AED); border-radius:12px; display:flex; align-items:center; justify-content:center; flex-shrink:0;">
                <svg width="22" height="22" fill="none" stroke="white" stroke-width="2" viewBox="0 0 24 24">
                    <path d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.3 2.3c-.63.63-.18 1.7.7 1.7H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z"/>
                </svg>
            </div>
            <div style="text-align:left; flex:1;">
                <div style="font-weight:700; font-size:14px; color:#1a162b;">Website Gitania</div>
                <div style="font-size:11.5px; color:#8B5CF6; font-weight:500;">Checkout langsung & aman 🔒</div>
            </div>
            <svg width="16" height="16" fill="none" stroke="#8B5CF6" stroke-width="2.5" viewBox="0 0 24 24"><polyline points="9 18 15 12 9 6"/></svg>
        </a>

        <!-- Divider -->
        <div style="display:flex; align-items:center; gap:10px; margin-bottom:12px;">
            <div style="flex:1; height:1px; background:#EDE9FE;"></div>
            <span style="font-size:11px; color:#9CA3AF; font-weight:600;">atau beli di marketplace</span>
            <div style="flex:1; height:1px; background:#EDE9FE;"></div>
        </div>

        <!-- Opsi 2: Shopee -->
        <a href="https://shopee.co.id/gitafajar2011?categoryId=100630&entryPoint=ShopByPDP&itemId=25591877640" target="_blank" rel="noopener noreferrer"
            style="display:flex; align-items:center; gap:14px; padding:14px 18px; border:2px solid #FFDDD6; border-radius:14px; text-decoration:none; margin-bottom:12px; background:#FFF8F6; transition:all 0.2s;"
            onmouseover="this.style.borderColor='#EE4D2D';this.style.background='#FFF1EE'"
            onmouseout="this.style.borderColor='#FFDDD6';this.style.background='#FFF8F6'"
        >
            <img src="/images/logo-shopee.jpg" alt="Shopee" style="width:44px; height:44px; object-fit:contain; border-radius:10px; background:white; padding:4px; border:1px solid #FFDDD6; flex-shrink:0;">
            <div style="text-align:left; flex:1;">
                <div style="font-weight:700; font-size:14px; color:#1a162b;">Shopee</div>
                <div style="font-size:11.5px; color:#EE4D2D; font-weight:500;">Beli di Shopee Official Store 🛍️</div>
            </div>
            <svg width="16" height="16" fill="none" stroke="#EE4D2D" stroke-width="2.5" viewBox="0 0 24 24"><polyline points="9 18 15 12 9 6"/></svg>
        </a>

        <!-- Opsi 3: Tokopedia (coming soon) -->
        <div style="display:flex; align-items:center; gap:14px; padding:14px 18px; border:2px solid #D4EDDA; border-radius:14px; background:#F4FDF6; opacity:0.6; cursor:not-allowed;">
            <img src="/images/logo-tokopedia.png" alt="Tokopedia" style="width:44px; height:44px; object-fit:contain; border-radius:10px; background:white; padding:4px; border:1px solid #D4EDDA; flex-shrink:0;">
            <div style="text-align:left; flex:1;">
                <div style="font-weight:700; font-size:14px; color:#1a162b;">Tokopedia</div>
                <div style="font-size:11.5px; color:#00AA5B; font-weight:500;">Segera hadir! 🔜</div>
            </div>
            <span style="background:#E8F5E9; color:#00AA5B; font-size:10px; font-weight:700; padding:3px 10px; border-radius:20px; white-space:nowrap;">Coming Soon</span>
        </div>

    </div>
</div>

<script>
    /* Buka modal pilihan checkout */
    function gtnOpenCheckoutModal() {
        var m = document.getElementById('gtnCheckoutModal');
        if (m) {
            m.style.display = 'flex';
            document.body.style.overflow = 'hidden';
        }
    }

    /* Tutup modal pilihan checkout */
    function gtnCloseCheckoutModal() {
        var m = document.getElementById('gtnCheckoutModal');
        if (m) {
            m.style.display = 'none';
            document.body.style.overflow = '';
        }
    }

    /* Tutup modal saat tekan ESC */
    document.addEventListener('keydown', function(e) {
        if (e.key === 'Escape') gtnCloseCheckoutModal();
    });
</script>
