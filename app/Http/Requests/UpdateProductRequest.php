<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateProductRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $product = $this->route('product');
        $productId = $product ? $product->id : null;

        return [
            'category_id' => 'required|exists:categories,id',
            'name' => 'required|string|max:255',
            'sku' => [
                'required',
                'string',
                'max:255',
                Rule::unique('products', 'sku')->ignore($productId),
            ],
            'price' => 'required|numeric|min:0',
            'weight' => 'required|numeric|min:0',
            'stock' => 'required|integer|min:0',
            'status' => 'required|in:active,inactive',
            'description' => 'nullable|string',

            // --- TAMBAHKAN KOLOM DETAIL TAB DI SINI ---
            'recommended_for' => 'nullable|string',
            'benefits' => 'nullable|string',
            'skin_concerns' => 'nullable|string',
            'how_to_use' => 'nullable|string',
            'ingredients' => 'nullable|string',
            // ----------------------------------------

            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',

            // Validasi untuk Varian Produk saat Update
            'variants' => 'nullable|array',
            'variants.*.variant_name' => 'required_with:variants|string|max:255',
            'variants.*.sku' => [
                'required_with:variants',
                'string',
                'max:255',
                function ($attribute, $value, $fail) {
                    $exists = \App\Models\ProductVariant::where('sku', $value)
                        ->whereHas('product', function ($query) {
                            $query->where('id', '!=', $this->route('product')?->id);
                        })
                        ->exists();

                    if ($exists) {
                        $fail("SKU varian '{$value}' sudah digunakan oleh produk lain.");
                    }
                },
            ],
            'variants.*.price' => 'required_with:variants|numeric|min:0',
            'variants.*.stock' => 'required_with:variants|integer|min:0',
            'variants.*.weight' => 'nullable|numeric|min:0',
            'variants.*.status' => 'nullable|string',

            // Validasi untuk Multi-Upload Gambar
            'images' => 'nullable|array',
            'images.*' => 'image|mimes:jpeg,png,jpg,webp|max:2048',
        ];
    }
}
