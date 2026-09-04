@php
    $cart = session()->get('cart', []);
    $subtotal = 0;
@endphp

<!-- Header Keranjang -->
<div style="display: flex; justify-content: space-between; align-items: center; border-bottom: 1px solid #EDE9FE; padding: 20px 24px; background: linear-gradient(135deg, #7C3AED, #6D28D9);">
    <div>
        <h3 style="margin: 0; font-size: 16px; font-weight: 700; color: #ffffff; display: flex; align-items: center; gap: 8px;">
            🛍️ KERANJANG
        </h3>
        <span style="font-size: 12px; color: rgba(255,255,255,0.75); margin-top: 2px; display: block;">({{ count($cart) }} Produk)</span>
    </div>
    <button onclick="toggleCart()" style="background: rgba(255,255,255,0.2); border: none; width: 34px; height: 34px; border-radius: 50%; font-size: 14px; cursor: pointer; color: white; font-weight: bold; display: flex; align-items: center; justify-content: center; transition: background 0.2s;"
        onmouseover="this.style.background='rgba(255,255,255,0.35)'"
        onmouseout="this.style.background='rgba(255,255,255,0.2)'"
    >✕</button>
</div>

<!-- Aksi Atas (Checkbox Semua, Favorit, Hapus) -->
<div style="display: flex; justify-content: space-between; align-items: center; padding: 12px 24px; background: #F5F3FF; border-bottom: 1px solid #EDE9FE; font-size: 13px;">
    <label style="display: flex; align-items: center; gap: 8px; font-weight: 600; cursor: pointer; color: #2d2638;">
        <input type="checkbox" checked style="accent-color: #7C3AED; width: 16px; height: 16px;"> Semua
    </label>
    <div style="display: flex; gap: 15px;">
        <span style="color: #7C3AED; cursor: pointer; font-weight: 600;">Favoritkan</span>
        <span style="color: #665c75; cursor: pointer; font-weight: 600;">Hapus</span>
    </div>
</div>

<!-- List Produk di Keranjang -->
<div style="padding: 16px 24px; flex: 1; overflow-y: auto; max-height: calc(100vh - 300px);">
    @forelse($cart as $id => $item)
        @php
            $itemTotal = $item['price'] * $item['quantity'];
            $subtotal += $itemTotal;
        @endphp
        <div style="display: flex; align-items: center; gap: 14px; padding-bottom: 16px; margin-bottom: 16px; border-bottom: 1px solid #EDE9FE;">
            <input type="checkbox" checked style="accent-color: #7C3AED; width: 16px; height: 16px;">
            <img src="{{ $item['image'] }}" style="width: 60px; height: 60px; object-fit: cover; border-radius: 10px; border: 1.5px solid #DDD6FE;">
            <div style="flex: 1;">
                <h4 style="margin: 0 0 4px 0; font-size: 13px; font-weight: 600; color: #2d2638; line-height: 1.3;">{{ $item['name'] }}</h4>
                <div style="color: #7C3AED; font-size: 13px; font-weight: 700; margin-bottom: 8px;">
                    Rp{{ number_format($item['price'], 0, ',', '.') }}
                </div>
                <div style="display: inline-flex; align-items: center; border: 1.5px solid #DDD6FE; border-radius: 8px; overflow: hidden; background: white;">
                    <button type="button" onclick="updateCartQty('{{ $id }}', -1)" style="padding: 3px 11px; background: none; border: none; cursor: pointer; font-weight: bold; color: #7C3AED; font-size: 15px;">−</button>
                    <span style="padding: 3px 11px; font-size: 12px; font-weight: 700; min-width: 18px; text-align: center; color: #1a162b;">{{ $item['quantity'] }}</span>
                    <button type="button" onclick="updateCartQty('{{ $id }}', 1)" style="padding: 3px 11px; background: none; border: none; cursor: pointer; font-weight: bold; color: #7C3AED; font-size: 15px;">+</button>
                </div>
            </div>
            <button onclick="removeCartItem('{{ $id }}')" style="background: #F5F3FF; border: 1px solid #DDD6FE; color: #7C3AED; cursor: pointer; width: 30px; height: 30px; border-radius: 8px; display: flex; align-items: center; justify-content: center; font-size: 13px; transition: background 0.2s;"
                onmouseover="this.style.background='#EDE9FE'"
                onmouseout="this.style.background='#F5F3FF'"
                title="Hapus">🗑️</button>
        </div>
    @empty
        <div style="text-align: center; color: #8B5CF6; padding: 50px 0 40px;">
            <div style="font-size: 44px; margin-bottom: 12px;">🛍️</div>
            <div style="font-size: 14px; font-weight: 600; color: #665c75;">Keranjang belanja Anda masih kosong.</div>
            <div style="font-size: 12px; color: #9CA3AF; margin-top: 6px;">Yuk, temukan produk favorit Anda!</div>
        </div>
    @endforelse
</div>

<!-- Bagian Bawah (Subtotal & Tombol Aksi) -->
<div style="border-top: 2px solid #EDE9FE; padding: 18px 24px; background: #FAFAFE; margin-top: auto;">
    <div style="display: flex; justify-content: space-between; font-size: 13px; margin-bottom: 6px;">
        <span style="color: #8B5CF6; font-weight: 600;">SubTOTAL</span>
        <span style="font-weight: 600; color: #2d2638;">Rp{{ number_format($subtotal, 0, ',', '.') }}</span>
    </div>
    <div style="display: flex; justify-content: space-between; font-weight: 800; font-size: 16px; margin-bottom: 4px; color: #2d2638;">
        <span>TOTAL BELANJA</span>
        <span style="color: #7C3AED;">Rp{{ number_format($subtotal, 0, ',', '.') }}</span>
    </div>
    <div style="font-size: 11px; color: #94a3b8; margin-bottom: 16px;">*Belum termasuk ongkir</div>

    <!-- Tombol Proses Pembayaran → panggil fungsi global dari cart-sidebar.blade.php -->
    <button onclick="gtnOpenCheckoutModal()" style="display: block; text-align: center; width: 100%; padding: 14px; background: linear-gradient(135deg, #8B5CF6, #7C3AED); color: white; border-radius: 12px; border: none; font-weight: 700; font-size: 14px; margin-bottom: 10px; box-shadow: 0 6px 20px rgba(124,58,237,0.30); box-sizing: border-box; cursor: pointer; font-family: inherit; transition: opacity 0.2s;"
        onmouseover="this.style.opacity='0.92'"
        onmouseout="this.style.opacity='1'"
    >
        Proses Pembayaran
    </button>

    <button onclick="toggleCart()" style="width: 100%; padding: 14px; background: white; border: 1.5px solid #8B5CF6; color: #7C3AED; border-radius: 12px; font-weight: 700; font-size: 14px; cursor: pointer; transition: background 0.2s; box-sizing: border-box; font-family: inherit;"
        onmouseover="this.style.background='#F5F3FF'"
        onmouseout="this.style.background='white'"
    >
        Lanjut Belanja
    </button>
</div>
