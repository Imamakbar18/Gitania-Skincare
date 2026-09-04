<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class ChatController extends Controller
{
    /**
     * Kata kunci yang menandakan user menanyakan produk/katalog.
     */
    private array $productKeywords = [
        'produk', 'product', 'katalog', 'catalog', 'jual', 'beli', 'harga', 'price',
        'skincare', 'serum', 'cream', 'krim', 'toner', 'cleanser', 'sunscreen',
        'moisturizer', 'moisturiser', 'ada apa', 'apa saja', 'apa aja', 'list',
        'daftar', 'rekomendasi', 'recommend', 'item', 'barang', 'stock', 'stok',
    ];

    public function chat(Request $request)
    {
        $userMessage = trim($request->input('message'));
        if (empty($userMessage)) {
            return response()->json(['success' => false, 'reply' => 'Pesan tidak boleh kosong.'], 400);
        }

        // 1. Ambil semua produk aktif beserta foto utama dari database
        $products = Product::with(['images' => function ($q) {
            $q->where('is_primary', true)->orWhere('order', 1)->orderBy('order');
        }])->where('status', 'active')->get();

        // 2. Bangun teks katalog untuk konteks AI
        $productCatalog = '';
        foreach ($products as $p) {
            $productCatalog .= '- ' . $p->name
                . ' (Harga: Rp ' . number_format($p->price, 0, ',', '.')
                . ', Stok: ' . $p->stock . ")\n";
        }

        $companyInfo = "
        Nama Brand: Gitania Skincare.
        Deskripsi: Local brand perawatan kulit dan tubuh berstandar klinis yang berdiri sejak 2023.
        Klinik Resmi: Klinik Pratama Rumah Hanania (Dokter & fasilitas medis estetika bersertifikat).
        Alamat Kantor/Klinik: Jl. Komud ABD. Saleh No.58, Krajan, Asrikaton, Kec. Pakis, Kabupaten Malang, Jawa Timur 65154.
        Kontak CS: WhatsApp 083815086540, Email skincaregitania@gmail.com, Instagram @gitaniaskincare.official.
        Metode Pembayaran: Midtrans (QRIS, GoPay, ShopeePay, Transfer Bank BCA/BNI/BRI/Mandiri, Kartu Kredit).
        Daftar Produk di Database:
        {$productCatalog}
        ";

        // 3. Deteksi apakah user bertanya soal produk/katalog
        $isProductQuery = $this->isAboutProducts(strtolower($userMessage));

        // 4. Siapkan payload produk untuk dikirim ke frontend (jika relevan)
        $productPayload = [];
        if ($isProductQuery) {
            foreach ($products as $p) {
                $primaryImage = $p->images->first();
                $productPayload[] = [
                    'id'        => $p->id,
                    'name'      => $p->name,
                    'price'     => number_format($p->price, 0, ',', '.'),
                    'stock'     => $p->stock,
                    'slug'      => $p->slug ?? $p->id,
                    'image_url' => $primaryImage
                        ? (str_starts_with($primaryImage->image_path, 'http') ? $primaryImage->image_path : asset('storage/' . $primaryImage->image_path))
                        : null,
                ];
            }
        }

        // 5. Coba request ke Groq AI API dengan timeout aman
        $apiKey = config('services.groq.key') ?: env('GROQ_API_KEY');

        if ($apiKey) {
            try {
                $response = Http::timeout(5)->withToken($apiKey)->post('https://api.groq.com/openai/v1/chat/completions', [
                    'model'    => 'openai/gpt-oss-120b',
                    'messages' => [
                        [
                            'role'    => 'system',
                            'content' => "Anda adalah Customer Service AI yang ramah, hangat, dan solutif untuk website Gitania Skincare. "
                                . "Jawab pertanyaan pengguna secara akurat berdasarkan informasi berikut:\n{$companyInfo}\n"
                                . "Jika user bertanya tentang produk, sebutkan nama produk dan keunggulannya dengan ringkas dan ramah. "
                                . "Jangan tampilkan tabel markdown karena daftar produk sudah ditampilkan secara visual.",
                        ],
                        [
                            'role'    => 'user',
                            'content' => $userMessage,
                        ],
                    ],
                    'temperature' => 0.7,
                ]);

                if ($response->successful()) {
                    $data = $response->json();
                    $aiReply = $data['choices'][0]['message']['content'] ?? null;
                    if (!empty($aiReply)) {
                        return response()->json([
                            'success'        => true,
                            'reply'          => $aiReply,
                            'show_products'  => $isProductQuery,
                            'products'       => $productPayload,
                        ]);
                    }
                }
            } catch (\Throwable $e) {
                Log::warning('Groq AI API tidak dapat dijangkau (kemungkinan diblokir hosting). Menggunakan Local AI Fallback Engine: ' . $e->getMessage());
            }
        }

        // 6. Jika Groq gagal / diblokir firewall hosting (InfinityFree), gunakan Local Intelligent Fallback Engine
        $localReply = $this->generateFallbackResponse($userMessage, $products, $isProductQuery);

        return response()->json([
            'success'        => true,
            'reply'          => $localReply,
            'show_products'  => $isProductQuery,
            'products'       => $productPayload,
        ]);
    }

    /**
     * Fallback Response Engine cerdas ketika hosting memblokir cURL eksternal.
     */
    private function generateFallbackResponse(string $message, $products, bool $isProductQuery): string
    {
        $msg = strtolower($message);

        // Salam / Greeting
        if (preg_match('/(halo|hai|hi|hello|pagi|siang|sore|malam|assalam|permisi)/i', $msg)) {
            return "Halo! ✨ Selamat datang di Gitania Skincare. Ada yang bisa aku bantu untuk konsultasi kulit, produk skincare, atau informasi klinik hari ini? 😊";
        }

        // Pertanyaan Jerawat / Bruntusan / Kulit Berminyak
        if (preg_match('/(jerawat|bruntus|acne|minyak|komedo|radang|beruntusan)/i', $msg)) {
            return "Untuk mengatasi kulit berjerawat dan bruntusan, Gitania Skincare merekomendasikan rangkaian perawatan berbahan aktif calming seperti Niacinamide & Centella Asiatica. Produk pembersih wajah dan serum kami diformulasikan khusus agar pori-pori bersih tanpa membuat kulit kering. Kamu juga bisa konsultasi langsung dengan dokter di Klinik Pratama Rumah Hanania! 🌸";
        }

        // Pertanyaan Mencerahkan / Flek / Kusam
        if (preg_match('/(kusam|cerah|mencerahkan|glowing|flek|noda|putih|glow)/i', $msg)) {
            return "Untuk mengatasi kulit kusam dan menyamarkan noda/flek hitam, kamu bisa menggunakan produk Gitania Radiant Glow Series & UV Shield Sunscreen. Formulanya menjaga kelembapan optimal sekaligus membuat kulit tampak glowing alami dan kenyal! ✨";
        }

        // Pertanyaan Sunscreen / Tabir Surya
        if (preg_match('/(sunscreen|tabir surya|spf|panas|matahari|uv)/i', $msg)) {
            return "Sunscreen Gitania Skincare dilengkapi dengan perlindungan UV spektrum luas dan tekstur ringan yang tidak lengket. Sangat cocok untuk iklim tropis Indonesia dan tidak menimbulkan whitecast! ☀️";
        }

        // Pertanyaan Klinik / Alamat / Lokasi
        if (preg_match('/(klinik|lokasi|alamat|cabang|malang|tempat|offline|toko)/i', $msg)) {
            return "Klinik resmi kami berlokasi di **Klinik Pratama Rumah Hanania**, Jl. Komud ABD. Saleh No.58, Krajan, Asrikaton, Kec. Pakis, Kabupaten Malang, Jawa Timur. Melayani konsultasi dokter ahli, IPL, meso, dan perawatan estetika modern. 🏥";
        }

        // Pertanyaan Pembayaran / Pengiriman / Cara Pesan
        if (preg_match('/(bayar|pembayaran|qris|transfer|ongkir|kirim|pesan|order|beli|midtrans)/i', $msg)) {
            return "Kamu bisa memesan produk langsung melalui website ini! Cukup masukkan produk ke keranjang, isi alamat, dan bayar dengan mudah & instan via **Midtrans** (QRIS, GoPay, ShopeePay, Transfer Bank, atau Kartu Kredit). Pesanan akan langsung diproses aman. 💳📦";
        }

        // Pertanyaan Kontak CS / Admin / WhatsApp
        if (preg_match('/(cs|admin|wa|whatsapp|hubungi|kontak|nomor)/i', $msg)) {
            return "Kamu bisa menghubungi Admin CS Gitania via WhatsApp di nomor **0838-1508-6540** atau melalui Instagram **@gitaniaskincare.official**. Kami siap membantu! 💬";
        }

        // Pertanyaan Katalog Produk
        if ($isProductQuery) {
            $total = $products->count();
            return "Berikut adalah katalog produk unggulan Gitania Skincare yang tersedia saat ini (Total {$total} produk). Silakan klik tombol di bawah untuk melihat detail atau memasukkan ke keranjang belanja kamu! 🛍️✨";
        }

        // Respon Umum / Solutif
        return "Terima kasih sudah menghubungi Gitania Skincare! 😊 Aku bisa membantu kamu memberikan rekomendasi produk sesuai jenis kulit, informasi klinik kecantikan Rumah Hanania, cara pemesanan, atau info kontak CS. Mau konsultasi tentang apa hari ini?";
    }

    /**
     * Cek apakah pesan user berkaitan dengan produk/katalog.
     */
    private function isAboutProducts(string $message): bool
    {
        foreach ($this->productKeywords as $kw) {
            if (str_contains($message, $kw)) {
                return true;
            }
        }
        return false;
    }
}
