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

        // 1. Ambil semua produk aktif beserta foto utama
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
        Alamat Kantor: Jl. Komud ABD. Saleh No.58, Krajan, Asrikaton, Kec. Pakis, Kabupaten Malang, Jawa Timur 65154.
        Kontak CS: Telepon (0341) 3022814, Email publicrelation@gitaniaskincare.com.
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
                    'slug'      => $p->slug,
                    'image_url' => $primaryImage
                        ? asset('storage/' . $primaryImage->image_path)
                        : null,
                ];
            }
        }

        // 5. Ambil API Key Groq
        $apiKey = config('services.groq.key');
        if (!$apiKey) {
            return response()->json([
                'success'  => false,
                'reply'    => 'Sistem Error: API Key Groq belum terbaca di file .env.',
                'products' => $productPayload,
            ], 500);
        }

        try {
            $response = Http::withToken($apiKey)->post('https://api.groq.com/openai/v1/chat/completions', [
                'model'    => 'openai/gpt-oss-120b',
                'messages' => [
                    [
                        'role'    => 'system',
                        'content' => "Anda adalah Customer Service AI yang ramah untuk website Gitania Skincare. "
                            . "Jawab pertanyaan pengguna berdasarkan informasi berikut:\n{$companyInfo}\n"
                            . "Jika user bertanya tentang produk, sebutkan daftar produk dengan singkat dan ramah. "
                            . "Jangan tampilkan tabel markdown. Cukup sebutkan nama dan harganya saja, karena foto produk sudah ditampilkan secara visual di bawah pesan ini.",
                    ],
                    [
                        'role'    => 'user',
                        'content' => $userMessage,
                    ],
                ],
                'temperature' => 0.7,
            ]);

            if ($response->successful()) {
                $data    = $response->json();
                $aiReply = $data['choices'][0]['message']['content'] ?? 'AI tidak memberikan respon.';

                return response()->json([
                    'success'        => true,
                    'reply'          => $aiReply,
                    'show_products'  => $isProductQuery,
                    'products'       => $productPayload,
                ]);
            }

            return response()->json([
                'success'  => false,
                'reply'    => 'Gagal dari Groq: ' . $response->body(),
                'products' => $productPayload,
            ]);

        } catch (\Exception $e) {
            Log::error('Groq API Exception: ' . $e->getMessage());
            return response()->json([
                'success'  => false,
                'reply'    => 'Terjadi kesalahan koneksi ke server AI.',
                'products' => $productPayload,
            ], 500);
        }
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
