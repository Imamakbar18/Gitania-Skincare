<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $product->name }} — Gitania Skincare</title>
    <!-- Google Fonts: Poppins & Playfair Display -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:ital,wght@0,400;0,500;0,600;0,700;1,400&family=Poppins:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <style>
        :root {
            --purple-deep: #4a2e7a;
            --primary: #6B21A8;
            --primary-dark: #581C87;
            --lilac-soft: #e2dcf5;
            --lilac-light: #faf8ff;
            --text-dark: #1a162b;
            --text-muted: #665c75;
            --accent-pink: #6B21A8;
            --accent-hover: #581C87;
            --border-soft: #DDD6FE;
        }

        body {
            font-family: 'Poppins', sans-serif;
            margin: 0;
            background: #FFFFFF;
            color: var(--text-dark);
        }

        .product-page-wrapper {
            max-width: 1100px;
            margin: 30px auto 80px auto;
            padding: 0 20px;
            box-sizing: border-box;
        }

        /* Breadcrumb */
        .breadcrumb {
            font-size: 13px;
            color: var(--text-muted);
            margin-bottom: 25px;
            line-height: 1.5;
        }
        .breadcrumb a { color: var(--purple-deep); text-decoration: none; font-weight: 600; }
        .breadcrumb a:hover { text-decoration: underline; }

        /* Gallery Layout */
        .product-container {
            width: 100%;
            margin: 20px auto 60px auto;
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 40px;
            align-items: start;
            box-sizing: border-box;
        }

        .product-gallery-wrapper {
            display: flex;
            gap: 16px;
            width: 100%;
        }

        .product-thumb-list {
            display: flex;
            flex-direction: column;
            gap: 10px;
            flex-shrink: 0;
        }

        .thumb-img {
            width: 75px;
            height: 75px;
            border-radius: 12px;
            overflow: hidden;
            cursor: pointer;
            background: #fff;
            border: 2px solid #e2e8f0;
            transition: all 0.2s ease;
            flex-shrink: 0;
        }
        .thumb-img:hover { border-color: var(--accent-pink); }
        .thumb-img.active { border-color: var(--accent-pink); box-shadow: 0 4px 12px rgba(107, 33, 168, 0.2); }

        .main-image-wrapper {
            flex: 1;
            min-width: 0;
            background: linear-gradient(145deg, #FAF5FF 0%, #EDE9FE 100%);
            border-radius: 20px;
            height: 480px;
            border: 1.5px solid var(--border-soft);
            box-shadow: 0 10px 30px rgba(74, 46, 122, 0.08);
            overflow: hidden;
            position: relative;
        }

        .main-image-wrapper img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            object-position: center;
            transition: transform 0.4s ease;
        }
        .main-image-wrapper:hover img {
            transform: scale(1.04);
        }

        /* Product Details */
        .product-title {
            font-size: 26px;
            font-weight: 700;
            color: var(--text-dark);
            margin: 0 0 15px 0;
            line-height: 1.3;
        }

        .product-price {
            font-size: 28px;
            font-weight: 700;
            color: var(--accent-pink);
            margin-bottom: 25px;
        }

        .badge-size {
            display: inline-flex;
            align-items: center;
            padding: 8px 18px;
            border: 1.5px solid var(--accent-pink);
            border-radius: 10px;
            color: var(--accent-pink);
            font-size: 13px;
            font-weight: 600;
            background: #fff5f8;
        }

        /* Qty Picker */
        .qty-wrapper {
            display: inline-flex;
            align-items: center;
            background: white;
            border: 1.5px solid #cbd5e1;
            border-radius: 10px;
            overflow: hidden;
        }
        .qty-btn {
            background: none;
            border: none;
            padding: 8px 16px;
            cursor: pointer;
            font-size: 16px;
            font-weight: 600;
            color: var(--text-muted);
        }
        .qty-btn:hover { background: #f8fafc; color: var(--text-dark); }
        .qty-input {
            width: 40px;
            text-align: center;
            border: none;
            font-size: 14px;
            font-weight: 600;
            color: var(--text-dark);
            outline: none;
            background: transparent;
        }

        /* Buttons */
        .btn-buy-direct {
            width: 100%;
            padding: 14px;
            background: white;
            border: 1.5px solid var(--text-dark);
            border-radius: 12px;
            color: var(--text-dark);
            font-size: 14px;
            font-weight: 700;
            cursor: pointer;
            transition: 0.2s;
        }
        .btn-buy-direct:hover { background: #f8fafc; }

        .btn-add-cart {
            width: 100%;
            padding: 14px;
            background: var(--accent-pink);
            border: none;
            border-radius: 12px;
            color: white;
            font-size: 14px;
            font-weight: 700;
            cursor: pointer;
            box-shadow: 0 4px 15px rgba(185, 56, 99, 0.3);
            transition: 0.2s;
        }
        .btn-add-cart:hover { background: var(--accent-hover); }

        /* Meta Features */
        .meta-features {
            display: flex;
            justify-content: space-between;
            align-items: center;
            border-top: 1px solid #f1f5f9;
            padding-top: 20px;
            margin-top: 30px;
            font-size: 13px;
            color: var(--text-muted);
            font-weight: 500;
        }
        .meta-item { cursor: pointer; display: flex; align-items: center; gap: 6px; transition: color 0.2s; }
        .meta-item:hover { color: var(--accent-pink); }

        /* Tabs Section */
        .tabs-header {
            border-bottom: 1px solid var(--border-soft);
            display: flex;
            gap: 30px;
            margin-bottom: 30px;
        }
        .tab-btn {
            background: none;
            border: none;
            font-size: 15px;
            font-weight: 600;
            color: #94a3b8;
            cursor: pointer;
            padding-bottom: 10px;
            position: relative;
        }
        .tab-btn:hover { color: var(--text-dark); }
        .tab-btn.active { color: var(--accent-pink); border-bottom: 2px solid var(--accent-pink); }

        .info-card {
            background: white;
            border: 1px solid var(--border-soft);
            border-radius: 16px;
            padding: 25px;
            box-shadow: 0 4px 15px rgba(185, 56, 99, 0.03);
        }

        /* Slide-out Mini Cart Styles */
        #cartSidebar {
            position: fixed;
            top: 0;
            right: -420px;
            width: 400px;
            height: 100%;
            background: white;
            z-index: 9999;
            box-shadow: -5px 0 25px rgba(0,0,0,0.15);
            transition: right 0.35s cubic-bezier(0.16, 1, 0.3, 1);
            display: flex;
            flex-direction: column;
            box-sizing: border-box;
        }
        #cartOverlay {
            position: fixed;
            top: 0; left: 0; width: 100%; height: 100%;
            background: rgba(0,0,0,0.4);
            backdrop-filter: blur(2px);
            display: none;
            z-index: 9998;
            transition: opacity 0.3s;
        }

        /* ===== RESPONSIVE BREAKPOINTS ===== */
        @media (max-width: 900px) {
            .product-container {
                grid-template-columns: 1fr;
                gap: 32px;
                margin: 20px auto 50px auto;
            }
            .product-gallery-wrapper {
                flex-direction: column-reverse;
                gap: 14px;
            }
            .product-thumb-list {
                flex-direction: row;
                overflow-x: auto;
                padding-bottom: 6px;
                width: 100%;
                -webkit-overflow-scrolling: touch;
            }
            .thumb-img {
                width: 65px;
                height: 65px;
            }
            .main-image-wrapper {
                height: 380px;
                width: 100%;
            }
            .product-title {
                font-size: 22px;
            }
            .tab-content[style*="grid-template-columns"] {
                grid-template-columns: 1fr !important;
            }
            .info-card[style*="grid-column: span 2"] {
                grid-column: span 1 !important;
            }
        }

        @media (max-width: 576px) {
            .main-image-wrapper {
                height: 290px;
                border-radius: 16px;
            }
            .thumb-img {
                width: 55px;
                height: 55px;
                border-radius: 10px;
            }
            .product-title {
                font-size: 20px;
                line-height: 1.35;
            }
            .product-price {
                font-size: 22px;
                margin-bottom: 18px;
            }
            .tabs-header {
                overflow-x: auto;
                gap: 16px;
                white-space: nowrap;
                -webkit-overflow-scrolling: touch;
            }
            .tab-btn {
                font-size: 13.5px;
            }
            .meta-features {
                flex-wrap: wrap;
                gap: 12px;
            }
            #cartSidebar {
                width: 100%;
                right: -100%;
            }
        }
    </style>
</head>
<body>
    @include('partials.navbar')

    @php
        $primaryImg = $product->images->where('is_primary', 1)->first() ?? $product->images->first();
        $imagePath = $primaryImg ? $primaryImg->image_path : $product->image;
        $mainImgSrc = Str::startsWith($imagePath, ['http://', 'https://']) ? $imagePath : asset('storage/' . $imagePath);
    @endphp

    <div class="product-page-wrapper">
        <!-- Breadcrumb -->
        <div class="breadcrumb">
            <a href="{{ route('home') }}">Home</a> &gt;
            <a href="{{ route('shop.index') }}">Our Products</a> &gt;
            <span style="font-weight: 600; color: var(--text-dark);">{{ $product->name }}</span>
        </div>

        <!-- Main Product Section -->
        <div class="product-container">

            <!-- Left Gallery -->
            <div class="product-gallery-wrapper">
                <div class="product-thumb-list">
                    @foreach($product->images as $index => $img)
                        @php
                            $subPath = $img->image_path;
                            $subSrc = Str::startsWith($subPath, ['http://', 'https://']) ? $subPath : asset('storage/' . $subPath);
                        @endphp
                        <div class="thumb-img {{ ($primaryImg && $primaryImg->id == $img->id) || (!$primaryImg && $index == 0) ? 'active' : '' }}" onclick="changeImage(this, '{{ $subSrc }}')">
                            <img src="{{ $subSrc }}" style="width: 100%; height: 100%; object-fit: cover;">
                        </div>
                    @endforeach
                </div>

                <div class="main-image-wrapper">
                    <img id="mainImage" src="{{ $mainImgSrc }}" alt="{{ $product->name }}">
                </div>
            </div>

            <!-- Right Info -->
            <div>
                <h1 class="product-title">{{ $product->name }}</h1>

                <div class="product-price">
                    Rp{{ number_format($product->price, 0, ',', '.') }}
                </div>

                <!-- Rating Singkat di Atas -->
                <div style="display: flex; align-items: center; gap: 8px; margin-bottom: 20px; font-size: 14px; font-weight: 600; color: var(--purple-deep);">
                    <span>⭐ {{ number_format($product->averageRating(), 1) }} / 5.0</span>
                    <span style="color: #cbd5e1;">|</span>
                    <span style="color: var(--text-muted); font-weight: 400;">({{ $product->reviews->count() }} Ulasan Pelanggan)</span>
                </div>

                <div style="margin-bottom: 25px;">
                    <label style="display: block; font-size: 12px; font-weight: 700; color: var(--text-muted); text-transform: uppercase; margin-bottom: 8px;">Ukuran</label>
                    <div class="badge-size">
                        {{ $product->weight ? $product->weight . 'ml' : 'Standard' }}
                    </div>
                </div>

                <form id="addCartForm" action="{{ route('cart.add') }}" method="POST">
                    @csrf
                    <input type="hidden" name="product_id" value="{{ $product->id }}">

                    <div style="margin-bottom: 25px;">
                        <label style="display: block; font-size: 12px; font-weight: 700; color: var(--text-muted); text-transform: uppercase; margin-bottom: 8px;">
                            Jumlah (Stok Tersedia: {{ $product->stock ?? 0 }})
                        </label>

                        @if(($product->stock ?? 0) > 0)
                            <div class="qty-wrapper">
                                <button type="button" class="qty-btn" onclick="decrementQty()">−</button>
                                <input type="number" id="quantity" name="quantity" value="1" min="1" max="{{ $product->stock }}" class="qty-input" readonly>
                                <button type="button" class="qty-btn" onclick="incrementQty({{ $product->stock }})">+</button>
                            </div>
                        @endif
                    </div>

                    <div style="display: flex; flex-direction: column; gap: 12px; margin-bottom: 25px;">
                        @if(($product->stock ?? 0) > 0)
                            <button type="button" class="btn-buy-direct">
                                Beli Langsung
                            </button>
                            <button type="submit" class="btn-add-cart">
                                + Tambahkan ke Keranjang
                            </button>
                        @else
                            <button type="button" disabled style="width: 100%; padding: 14px; background: #e2e8f0; border: none; border-radius: 12px; color: #94a3b8; font-size: 14px; font-weight: 700; cursor: not-allowed;">
                                🚫 Stok Habis
                            </button>
                        @endif
                    </div>
                </form>
            </div>
        </div>

        <!-- Tabs Section -->
        <div class="tabs-header">
            <button class="tab-btn active" onclick="showTab(event, 'details')">Product Details</button>
            <button class="tab-btn" onclick="showTab(event, 'howtouse')">How to Use</button>
            <button class="tab-btn" onclick="showTab(event, 'ingredients')">Ingredients</button>
        </div>

        <!-- Tab Details -->
        <div id="details" class="tab-content" style="display: grid; grid-template-columns: 1fr 1fr; gap: 20px;">
            <div class="info-card">
                <h4 style="margin: 0 0 10px 0; color: var(--text-dark);">Recommended For</h4>
                <p style="margin: 0; color: #64748b; font-size: 14px; line-height: 1.6;">{{ $product->recommended_for ?? 'Belum ada data' }}</p>
            </div>
            <div class="info-card">
                <h4 style="margin: 0 0 10px 0; color: var(--text-dark);">Benefits</h4>
                <p style="margin: 0; color: #64748b; font-size: 14px; line-height: 1.6;">{{ $product->benefits ?? 'Belum ada data' }}</p>
            </div>
            <div class="info-card" style="grid-column: span 2;">
                <h4 style="margin: 0 0 10px 0; color: var(--text-dark);">Skin Concerns</h4>
                <p style="margin: 0; color: #64748b; font-size: 14px; line-height: 1.6;">{{ $product->skin_concerns ?? 'Belum ada data' }}</p>
            </div>
        </div>

        <!-- Tab How to Use -->
        <div id="howtouse" class="tab-content" style="display: none;">
            <div class="info-card">
                <h4 style="margin: 0 0 10px 0; color: var(--text-dark);">Cara Penggunaan</h4>
                <p style="margin: 0; color: #64748b; font-size: 14px; line-height: 1.6;">{{ $product->how_to_use ?? 'Belum ada data' }}</p>
            </div>
        </div>

        <!-- Tab Ingredients -->
        <div id="ingredients" class="tab-content" style="display: none;">
            <div class="info-card">
                <h4 style="margin: 0 0 10px 0; color: var(--text-dark);">Komposisi / Ingredients</h4>
                <p style="margin: 0; color: #64748b; font-size: 14px; line-height: 1.6;">{{ $product->ingredients ?? 'Belum ada data' }}</p>
            </div>
        </div>

        <!-- --- SECTION ULASAN & TESTIMONI PEMBELI --- -->
        <div style="margin-top: 60px; background: white; border: 1px solid var(--border-soft); border-radius: 20px; padding: 35px; box-shadow: 0 4px 15px rgba(185, 56, 99, 0.03);">
            <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px; border-bottom: 1px solid #eee; padding-bottom: 15px; flex-wrap: wrap; gap: 15px;">
                <h3 style="font-size: 20px; font-weight: 700; color: var(--purple-deep); margin: 0;">
                    ⭐ Ulasan & Penilaian Pembeli
                </h3>
                <div style="font-size: 15px; font-weight: 600; color: var(--accent-pink); background: #fff5f8; padding: 6px 15px; border-radius: 12px; border: 1px solid var(--border-soft);">
                    {{ number_format($product->averageRating(), 1) }} dari 5.0 ({{ $product->reviews->count() }} Ulasan)
                </div>
            </div>

            <!-- Bagian Filter Ulasan (Bintang 1-5) -->
            <div style="margin-bottom: 25px; display: flex; gap: 10px; flex-wrap: wrap; align-items: center;">
                <span style="font-size: 13px; font-weight: 600; color: var(--text-dark);">Filter Ulasan:</span>

                <!-- Tombol Semua -->
                <a href="{{ route('products.show', $product->slug) }}" style="padding: 6px 14px; border-radius: 20px; font-size: 12px; font-weight: 600; text-decoration: none; background: {{ !request('rating') ? 'var(--purple-deep)' : 'var(--lilac-light)' }}; color: {{ !request('rating') ? 'white' : 'var(--purple-deep)' }}; border: 1px solid var(--lilac-soft);">
                    Semua
                </a>

                <!-- Tombol Bintang 5 sampai 1 -->
                @foreach(range(5, 1) as $star)
                    <a href="{{ route('products.show', ['slug' => $product->slug, 'rating' => $star]) }}" style="padding: 6px 14px; border-radius: 20px; font-size: 12px; font-weight: 600; text-decoration: none; background: {{ request('rating') == $star ? 'var(--purple-deep)' : 'var(--lilac-light)' }}; color: {{ request('rating') == $star ? 'white' : 'var(--purple-deep)' }}; border: 1px solid var(--lilac-soft);">
                        ⭐ {{ $star }} ({{ $product->reviews()->where('rating', $star)->count() }})
                    </a>
                @endforeach
            </div>

            @php
                $filteredReviews = $product->reviews();
                if(request('rating')) {
                    $filteredReviews->where('rating', request('rating'));
                }
                $reviewsList = $filteredReviews->latest()->get();
            @endphp

            @if($reviewsList->count() > 0)
                <div style="display: flex; flex-direction: column; gap: 15px;">
                    @foreach($reviewsList as $review)
                        <div style="background: #faf8ff; border: 1px solid #e2dcf5; border-radius: 14px; padding: 20px;">
                            <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 8px;">
                                <span style="font-weight: 600; font-size: 15px; color: var(--text-dark);">
                                    {{ $review->order->customer_name ?? 'Pelanggan Setia' }}
                                </span>
                                <span style="color: #f59e0b; font-size: 14px; letter-spacing: 2px;">
                                    {!! str_repeat('⭐', $review->rating) !!}
                                </span>
                            </div>
                            @if(!empty($review->comment))
                                <p style="font-size: 14px; color: var(--text-muted); margin: 8px 0 0 0; line-height: 1.5;">{{ $review->comment }}</p>
                            @else
                                <p style="font-size: 13px; color: #94a3b8; font-style: italic; margin: 8px 0 0 0;">(Pelanggan memberikan rating bintang tanpa komentar tertulis)</p>
                            @endif
                            <div style="font-size: 12px; color: #94a3b8; margin-top: 10px;">
                                Diberikan pada {{ $review->created_at->format('d M Y') }}
                            </div>
                        </div>
                    @endforeach
                </div>
            @else
                <div style="text-align: center; padding: 40px 20px; color: var(--text-muted);">
                    <div style="font-size: 36px; margin-bottom: 10px;">💬</div>
                    <p style="font-size: 15px; font-weight: 600; color: var(--purple-deep); margin-bottom: 5px;">Tidak ada ulasan dengan filter bintang ini.</p>
                    <p style="font-size: 13px; margin: 0;">Coba pilih kategori filter bintang yang lain.</p>
                </div>
            @endif
        </div>
    </div>


    <!-- Mini Cart Slide-out Component -->
    <div id="cartOverlay" onclick="toggleCart()"></div>
    <div id="cartSidebar">
        <div id="cartDrawerContainer" style="display: flex; flex-direction: column; height: 100%;">
            @include('partials.cart-drawer-content')
        </div>
    </div>

    @include('partials.chatbot')

    @include('partials.footer')

    <script>
        function toggleCart() {
            let sidebar = document.getElementById('cartSidebar');
            let overlay = document.getElementById('cartOverlay');
            if (sidebar.style.right === '0px') {
                sidebar.style.right = '-420px';
                overlay.style.display = 'none';
            } else {
                sidebar.style.right = '0px';
                overlay.style.display = 'block';
                refreshCartDrawer();
            }
        }

        function refreshCartDrawer() {
            fetch("{{ route('cart.data') }}")
            .then(response => response.json())
            .then(data => {
                document.getElementById('cartDrawerContainer').innerHTML = data.html;
            })
            .catch(error => console.error('Error loading cart data:', error));
        }

        // AJAX Add to Cart
        document.getElementById('addCartForm').addEventListener('submit', function(e) {
            e.preventDefault();
            let formData = new FormData(this);

            fetch("{{ route('cart.add') }}", {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                    'X-Requested-With': 'XMLHttpRequest',
                    'Accept': 'application/json'
                },
                body: formData
            })
            .then(async response => {
                let textResponse = await response.text();
                let data;
                try {
                    data = JSON.parse(textResponse);
                } catch (err) {
                    throw new Error("Server mengembalikan format non-JSON: " + textResponse.substring(0, 150));
                }

                if (!response.ok) {
                    throw new Error(data.message || 'Gagal menambahkan produk.');
                }
                return data;
            })
            .then(data => {
                if(data.success) {
                    document.getElementById('cartDrawerContainer').innerHTML = data.html;
                    toggleCart();
                }
            })
            .catch(error => {
                console.error('AJAX Error:', error);
                alert(error.message);
            });
        });

        function updateCartQty(productId, change) {
            let formData = new FormData();
            formData.append('product_id', productId);
            formData.append('change', change);
            formData.append('_token', '{{ csrf_token() }}');

            fetch("{{ route('cart.update') }}", {
                method: 'POST',
                headers: { 'X-Requested-With': 'XMLHttpRequest' },
                body: formData
            })
            .then(response => response.json())
            .then(data => {
                if(data.success) {
                    document.getElementById('cartDrawerContainer').innerHTML = data.html;
                } else {
                    alert(data.message || 'Stok tidak mencukupi');
                }
            });
        }

        function removeCartItem(productId) {
            let formData = new FormData();
            formData.append('product_id', productId);
            formData.append('_token', '{{ csrf_token() }}');

            fetch("{{ route('cart.ajax.remove') }}", {
                method: 'POST',
                headers: { 'X-Requested-With': 'XMLHttpRequest' },
                body: formData
            })
            .then(response => response.json())
            .then(data => {
                if(data.success) {
                    document.getElementById('cartDrawerContainer').innerHTML = data.html;
                }
            });
        }

        function changeImage(element, src) {
            document.getElementById('mainImage').src = src;
            document.querySelectorAll('.thumb-img').forEach(el => el.classList.remove('active'));
            element.classList.add('active');
        }

        function incrementQty(maxStock) {
            let qtyInput = document.getElementById('quantity');
            let currentVal = parseInt(qtyInput.value);
            if (currentVal < maxStock) {
                qtyInput.value = currentVal + 1;
            }
        }

        function decrementQty() {
            let qtyInput = document.getElementById('quantity');
            let currentVal = parseInt(qtyInput.value);
            if (currentVal > 1) {
                qtyInput.value = currentVal - 1;
            }
        }

        function showTab(event, id) {
            document.querySelectorAll('.tab-content').forEach(el => el.style.display = 'none');
            document.querySelectorAll('.tab-btn').forEach(el => el.classList.remove('active'));

            let target = document.getElementById(id);
            if (id === 'details') {
                target.style.display = 'grid';
            } else {
                target.style.display = 'block';
            }
            event.currentTarget.classList.add('active');
        }

        // Beli Langsung
        document.querySelector('.btn-buy-direct')?.addEventListener('click', function() {
            let form = document.getElementById('addCartForm');
            let formData = new FormData(form);
            fetch("{{ route('cart.add') }}", {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                    'X-Requested-With': 'XMLHttpRequest',
                    'Accept': 'application/json'
                },
                body: formData
            }).then(() => {
                window.location.href = "{{ route('cart.index') }}";
            }).catch(() => {
                window.location.href = "{{ route('cart.index') }}";
            });
        });
    </script>
</body>
</html>
