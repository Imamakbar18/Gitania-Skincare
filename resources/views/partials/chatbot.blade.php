{{-- ============================================================
     CHATBOT PARTIAL — GITANIA SKINCARE
     Pastikan hanya di-include SATU KALI per halaman
     ============================================================ --}}

@once
@php
    try {
        $gtnDbProducts = \App\Models\Product::with(['images' => function($q) {
            $q->where('is_primary', true)->orWhere('order', 1)->orderBy('order');
        }])->where('status', 'active')->get()->map(function($p) {
            $img = $p->images ? $p->images->first() : null;
            $imgUrl = null;
            if ($img) {
                $imgUrl = str_starts_with($img->image_path, 'http') 
                    ? $img->image_path 
                    : asset('storage/' . $img->image_path);
            }
            return [
                'id'        => $p->id,
                'name'      => $p->name,
                'price'     => number_format($p->price, 0, ',', '.'),
                'stock'     => $p->stock,
                'slug'      => $p->slug ?? $p->id,
                'image_url' => $imgUrl,
            ];
        })->values();
    } catch (\Throwable $e) {
        $gtnDbProducts = collect();
    }
@endphp

<!-- Chatbot Button -->
<button
    id="gtn-chat-trigger"
    onclick="gtnToggleChat()"
    style="
        position: fixed;
        bottom: 24px;
        right: 24px;
        display: flex;
        align-items: center;
        gap: 8px;
        padding: 12px 22px;
        background: linear-gradient(135deg, #8B5CF6, #7C3AED);
        color: white;
        border: none;
        border-radius: 999px;
        cursor: pointer;
        font-weight: 700;
        font-size: 13px;
        font-family: 'Poppins', sans-serif;
        box-shadow: 0 6px 20px rgba(124, 58, 237, 0.4);
        z-index: 99999;
        transition: transform 0.2s, box-shadow 0.2s;
    "
    onmouseover="this.style.transform='translateY(-2px)';this.style.boxShadow='0 10px 28px rgba(124,58,237,0.55)'"
    onmouseout="this.style.transform='translateY(0)';this.style.boxShadow='0 6px 20px rgba(124,58,237,0.4)'"
>
    <svg width="16" height="16" fill="none" stroke="currentColor" stroke-width="2.2" viewBox="0 0 24 24">
        <path d="M21 15a2 2 0 0 1-2 2H7l-4 4V5a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2z"/>
    </svg>
    Talk to Us!
</button>

<!-- Chatbot Modal -->
<div
    id="gtn-chat-modal"
    style="
        display: none;
        position: fixed;
        bottom: 84px;
        right: 24px;
        width: 380px;
        max-width: calc(100vw - 32px);
        height: 540px;
        max-height: calc(100vh - 120px);
        background: white;
        border-radius: 20px;
        box-shadow: 0 16px 48px rgba(109,40,217,0.18);
        flex-direction: column;
        z-index: 99998;
        overflow: hidden;
        border: 1px solid #DDD6FE;
    "
>
    <!-- Header Modal -->
    <div style="background: linear-gradient(135deg, #7C3AED, #6D28D9); color: white; padding: 16px 20px; display: flex; justify-content: space-between; align-items: center; flex-shrink: 0;">
        <div style="display: flex; align-items: center; gap: 10px;">
            <div style="width: 36px; height: 36px; background: rgba(255,255,255,0.2); border-radius: 50%; display: flex; align-items: center; justify-content: center; font-size: 16px;">✨</div>
            <div>
                <div style="font-weight: 700; font-size: 14px;">Gitania AI Assistant</div>
                <div style="font-size: 11px; opacity: 0.85;">Siap membantu Anda 24/7</div>
            </div>
        </div>
        <button
            onclick="gtnToggleChat()"
            style="background: rgba(255,255,255,0.2); border: none; color: white; width: 30px; height: 30px; border-radius: 8px; cursor: pointer; font-size: 16px; display: flex; align-items: center; justify-content: center; transition: background 0.2s;"
            onmouseover="this.style.background='rgba(255,255,255,0.35)'"
            onmouseout="this.style.background='rgba(255,255,255,0.2)'"
        >✕</button>
    </div>

    <!-- Chat Messages Area -->
    <div id="gtn-chat-box" style="flex: 1; padding: 16px; overflow-y: auto; background: #F5F3FF; display: flex; flex-direction: column; gap: 10px;">
        <div style="align-self: flex-start; background: white; padding: 10px 14px; border-radius: 14px 14px 14px 4px; font-size: 13px; color: #374151; max-width: 85%; box-shadow: 0 2px 8px rgba(109,40,217,0.08); border: 1px solid #EDE9FE;">
            Halo! 👋 Ada yang bisa aku bantu seputar produk Gitania Skincare, konsultasi kulit, atau klinik kecantikan?
        </div>
    </div>

    <!-- Chat Input Area -->
    <div style="padding: 12px 14px; border-top: 1px solid #EDE9FE; display: flex; gap: 8px; background: white; flex-shrink: 0;">
        <input
            type="text"
            id="gtn-chat-input"
            placeholder="Tulis pertanyaan Anda..."
            style="flex: 1; padding: 10px 14px; border: 1.5px solid #DDD6FE; border-radius: 10px; outline: none; font-size: 13px; font-family: 'Poppins', sans-serif; color: #374151; transition: border-color 0.2s;"
            onfocus="this.style.borderColor='#8B5CF6'"
            onblur="this.style.borderColor='#DDD6FE'"
        >
        <button
            id="gtn-chat-send"
            style="padding: 10px 16px; background: linear-gradient(135deg, #8B5CF6, #7C3AED); color: white; border: none; border-radius: 10px; cursor: pointer; font-weight: 700; font-size: 13px; font-family: 'Poppins', sans-serif; transition: opacity 0.2s;"
        >
            <svg width="16" height="16" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><line x1="22" y1="2" x2="11" y2="13"/><polygon points="22 2 15 22 11 13 2 9 22 2"/></svg>
        </button>
    </div>
</div>

<style>
/* ── Kartu Produk dalam Chat ── */
.gtn-product-grid {
    display: grid;
    grid-template-columns: repeat(2, 1fr);
    gap: 8px;
    margin-top: 8px;
    width: 100%;
}
.gtn-product-card {
    background: white;
    border: 1px solid #EDE9FE;
    border-radius: 12px;
    overflow: hidden;
    box-shadow: 0 2px 8px rgba(109,40,217,0.07);
    transition: transform 0.2s, box-shadow 0.2s;
    text-decoration: none;
    display: flex;
    flex-direction: column;
}
.gtn-product-card:hover {
    transform: translateY(-2px);
    box-shadow: 0 6px 16px rgba(124,58,237,0.18);
}
.gtn-product-card img {
    width: 100%;
    aspect-ratio: 1 / 1;
    object-fit: cover;
    background: #F5F3FF;
}
.gtn-product-card .gtn-no-img {
    width: 100%;
    aspect-ratio: 1 / 1;
    background: linear-gradient(135deg, #EDE9FE, #F5F3FF);
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 28px;
}
.gtn-product-card .gtn-card-body {
    padding: 8px 9px;
    flex: 1;
    display: flex;
    flex-direction: column;
    gap: 3px;
}
.gtn-product-card .gtn-card-name {
    font-size: 11.5px;
    font-weight: 700;
    color: #1f2937;
    line-height: 1.3;
    display: -webkit-box;
    -webkit-line-clamp: 2;
    -webkit-box-orient: vertical;
    overflow: hidden;
}
.gtn-product-card .gtn-card-price {
    font-size: 11px;
    color: #7C3AED;
    font-weight: 700;
}
.gtn-product-card .gtn-card-stock {
    font-size: 10px;
    color: #6b7280;
}
.gtn-product-card .gtn-card-btn {
    margin: 0 9px 8px;
    padding: 5px 0;
    background: linear-gradient(135deg, #8B5CF6, #7C3AED);
    color: white;
    border: none;
    border-radius: 6px;
    font-size: 10.5px;
    font-weight: 700;
    cursor: pointer;
    text-align: center;
    text-decoration: none;
    display: block;
    transition: opacity 0.2s;
}
.gtn-product-card .gtn-card-btn:hover { opacity: 0.88; }
</style>

<script>
(function() {
    // ===== STATE & DATA =====
    var chatOpen = false;
    var GTN_LOCAL_PRODUCTS = @json($gtnDbProducts);

    // ===== TOGGLE CHAT =====
    window.gtnToggleChat = function() {
        var modal = document.getElementById('gtn-chat-modal');
        if (!modal) return;
        chatOpen = !chatOpen;
        modal.style.display = chatOpen ? 'flex' : 'none';
        if (chatOpen) {
            var input = document.getElementById('gtn-chat-input');
            if (input) input.focus();
        }
    };

    // ===== BUILD PRODUCT CARDS HTML =====
    function buildProductCards(products) {
        if (!products || products.length === 0) return '';

        var html = '<div class="gtn-product-grid">';
        products.forEach(function(p) {
            var imgHtml = p.image_url
                ? '<img src="' + p.image_url + '" alt="' + p.name + '" loading="lazy">'
                : '<div class="gtn-no-img">🧴</div>';

            var productUrl = '{{ url("/products") }}/' + (p.slug || p.id);

            html += '<a class="gtn-product-card" href="' + productUrl + '">'
                + imgHtml
                + '<div class="gtn-card-body">'
                +   '<div class="gtn-card-name">' + p.name + '</div>'
                +   '<div class="gtn-card-price">Rp ' + p.price + '</div>'
                +   '<div class="gtn-card-stock">Stok: ' + p.stock + '</div>'
                + '</div>'
                + '<span class="gtn-card-btn">Lihat Produk →</span>'
                + '</a>';
        });
        html += '</div>';
        return html;
    }

    // ===== CLIENT INTELLIGENT FALLBACK ENGINE =====
    function getSmartClientReply(userMsg, products) {
        var msg = (userMsg || '').toLowerCase();
        var prods = Array.isArray(products) && products.length > 0 ? products : GTN_LOCAL_PRODUCTS;

        // 1. Produk / Katalog / Harga / Jual / Beli / List / Rekomendasi
        if (/(produk|product|katalog|catalog|jual|beli|harga|price|skincare|serum|cream|krim|toner|cleanser|ada apa|apa saja|apa aja|list|daftar|rekomendasi|item|barang|stok|stock)/i.test(msg)) {
            var totalCount = prods.length;
            return {
                reply: "Berikut adalah katalog produk unggulan Gitania Skincare yang tersedia di website kami (" + totalCount + " varian produk). Silakan klik pada produk untuk melihat rincian detail dan memesan! 🛍️✨",
                show_products: true,
                products: prods
            };
        }

        // 2. Jerawat / Acne / Bruntusan / Kulit Berminyak
        if (/(jerawat|bruntus|acne|minyak|komedo|radang|beruntusan)/i.test(msg)) {
            return {
                reply: "Untuk masalah kulit berjerawat dan bruntusan, Gitania Skincare merekomendasikan pembersih wajah lembut dan serum berbahan aktif calming (Niacinamide & Centella Asiatica) yang membersihkan pori secara mendalam tanpa mengeringkan kulit. Kamu juga dapat berkonsultasi langsung dengan dokter spesialis kami di Klinik Pratama Rumah Hanania! 🌸",
                show_products: true,
                products: prods
            };
        }

        // 3. Mencerahkan / Kusam / Glowing / Flek
        if (/(kusam|cerah|mencerahkan|glowing|flek|noda|putih|glow|bekas)/i.test(msg)) {
            return {
                reply: "Untuk mengatasi kulit kusam dan menyamarkan noda hitam bekas jerawat, rangkaian Gitania Radiant Glow Series & UV Shield Sunscreen sangat efektif mengembalikan kelembapan serta membuat kulit tampak lebih cerah dan glowing alami! ✨",
                show_products: true,
                products: prods
            };
        }

        // 4. Sunscreen / Tabir Surya
        if (/(sunscreen|tabir surya|spf|panas|matahari|uv)/i.test(msg)) {
            return {
                reply: "Sunscreen Gitania Skincare diformulasikan dengan perlindungan UV spektrum luas yang ringan, mudah meresap, dan tidak menimbulkan whitecast. Wajib dipakai setiap pagi sebelum beraktivitas! ☀️",
                show_products: true,
                products: prods
            };
        }

        // 5. Klinik / Alamat / Lokasi
        if (/(klinik|lokasi|alamat|cabang|malang|tempat|offline|toko|rumah hanania)/i.test(msg)) {
            return {
                reply: "Klinik resmi kami berlokasi di **Klinik Pratama Rumah Hanania**, Jl. Komud ABD. Saleh No.58, Krajan, Asrikaton, Kec. Pakis, Kabupaten Malang, Jawa Timur. Kami melayani konsultasi dokter, IPL, facial, meso, dan perawatan estetika medis lainnya. 🏥",
                show_products: false,
                products: []
            };
        }

        // 6. Pembayaran / Pengiriman / Cara Pesan
        if (/(bayar|pembayaran|qris|transfer|ongkir|kirim|pesan|order|beli|midtrans)/i.test(msg)) {
            return {
                reply: "Pemesanan produk sangat mudah! Cukup masukkan produk ke keranjang belanja, isi alamat pengiriman, dan bayar aman secara instan via **Midtrans** (QRIS, GoPay, ShopeePay, Transfer Bank BCA/BNI/BRI/Mandiri, atau Kartu Kredit). 💳📦",
                show_products: false,
                products: []
            };
        }

        // 7. Kontak CS / WhatsApp
        if (/(cs|admin|wa|whatsapp|hubungi|kontak|nomor|telepon)/i.test(msg)) {
            return {
                reply: "Kamu bisa menghubungi Admin CS Gitania via WhatsApp di nomor **0838-1508-6540** atau Instagram **@gitaniaskincare.official**. Kami siap membantu dengan senang hati! 💬",
                show_products: false,
                products: []
            };
        }

        // 8. Salam / Greeting
        if (/(halo|hai|hi|hello|pagi|siang|sore|malam|assalam|permisi|aaa|tes|test)/i.test(msg)) {
            return {
                reply: "Halo! ✨ Selamat datang di Gitania Skincare. Ada yang bisa aku bantu untuk rekomendasi produk, konsultasi jenis kulit, info klinik kecantikan, atau pemesanan hari ini? 😊",
                show_products: false,
                products: []
            };
        }

        // Default
        return {
            reply: "Terima kasih sudah menghubungi Gitania Skincare! ✨ Aku siap membantu memberikan rekomendasi produk perawatan kulit, informasi klinik kecantikan Rumah Hanania, cara pemesanan, atau info kontak CS. Mau tanya tentang apa hari ini?",
            show_products: false,
            products: []
        };
    }

    // ===== SEND MESSAGE =====
    function gtnSendMessage() {
        var input   = document.getElementById('gtn-chat-input');
        var chatBox = document.getElementById('gtn-chat-box');
        if (!input || !chatBox) return;

        var msg = input.value.trim();
        if (!msg) return;

        // Tampilkan pesan user
        var userBubble = document.createElement('div');
        userBubble.style.cssText = 'align-self: flex-end; background: linear-gradient(135deg, #8B5CF6, #7C3AED); color: white; padding: 10px 14px; border-radius: 14px 14px 4px 14px; font-size: 13px; max-width: 80%; word-wrap: break-word;';
        userBubble.textContent = msg;
        chatBox.appendChild(userBubble);
        input.value = '';
        chatBox.scrollTop = chatBox.scrollHeight;

        // Loading bubble
        var loadingBubble = document.createElement('div');
        var loadingId = 'gtn-loading-' + Date.now();
        loadingBubble.id = loadingId;
        loadingBubble.style.cssText = 'align-self: flex-start; background: white; color: #9CA3AF; padding: 10px 14px; border-radius: 14px 14px 14px 4px; font-size: 13px; border: 1px solid #EDE9FE;';
        loadingBubble.textContent = '✍️ Sedang mengetik...';
        chatBox.appendChild(loadingBubble);
        chatBox.scrollTop = chatBox.scrollHeight;

        // Fungsi render balasan
        function renderAiResponse(data) {
            var loadingEl = document.getElementById(loadingId);
            if (loadingEl) loadingEl.remove();

            var wrapper = document.createElement('div');
            wrapper.style.cssText = 'align-self: flex-start; display: flex; flex-direction: column; gap: 8px; max-width: 92%; width: 100%;';

            var replyBubble = document.createElement('div');
            replyBubble.style.cssText = 'background: white; color: #374151; padding: 10px 14px; border-radius: 14px 14px 14px 4px; font-size: 13px; word-wrap: break-word; border: 1px solid #EDE9FE; box-shadow: 0 2px 8px rgba(109,40,217,0.07); line-height: 1.55;';
            replyBubble.innerHTML = (data.reply || '').replace(/\n/g, '<br>');
            wrapper.appendChild(replyBubble);

            if (data.show_products && data.products && data.products.length > 0) {
                var cardsHtml = buildProductCards(data.products);
                var cardsEl   = document.createElement('div');
                cardsEl.innerHTML = cardsHtml;
                wrapper.appendChild(cardsEl.firstChild);
            }

            chatBox.appendChild(wrapper);
            chatBox.scrollTop = chatBox.scrollHeight;
        }

        // Kirim ke backend Laravel
        var csrfMeta  = document.querySelector('meta[name="csrf-token"]');
        var csrfToken = csrfMeta ? csrfMeta.getAttribute('content') : '';

        fetch("{{ url('/ai-chat') }}", {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': csrfToken,
                'X-Requested-With': 'XMLHttpRequest',
                'Content-Type': 'application/json',
                'Accept': 'application/json'
            },
            body: JSON.stringify({ message: msg })
        })
        .then(function(res) {
            return res.text().then(function(text) {
                try {
                    var parsed = JSON.parse(text);
                    if (parsed && parsed.success && parsed.reply) {
                        return parsed;
                    }
                } catch(e) {
                    // Fallback to client engine jika response non-JSON (misal firewall InfinityFree)
                }
                return getSmartClientReply(msg, GTN_LOCAL_PRODUCTS);
            });
        })
        .then(function(finalData) {
            renderAiResponse(finalData);
        })
        .catch(function(err) {
            var fallbackData = getSmartClientReply(msg, GTN_LOCAL_PRODUCTS);
            renderAiResponse(fallbackData);
        });
    }

    // ===== EVENT LISTENERS =====
    function initChat() {
        var sendBtn   = document.getElementById('gtn-chat-send');
        var chatInput = document.getElementById('gtn-chat-input');

        if (sendBtn)   sendBtn.addEventListener('click', gtnSendMessage);
        if (chatInput) chatInput.addEventListener('keypress', function(e) {
            if (e.key === 'Enter') gtnSendMessage();
        });
    }

    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', initChat);
    } else {
        initChat();
    }
})();
</script>
@endonce
