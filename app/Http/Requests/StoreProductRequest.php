<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreProductRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'category_id' => 'required|exists:categories,id',
            'name' => 'required|string|max:255',
            'sku' => 'required|string|max:255|unique:products,sku',
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

            // Validasi untuk Varian Produk
            'variants' => 'nullable|array',
            'variants.*.variant_name' => 'required_with:variants|string|max:255',
            'variants.*.sku' => 'required_with:variants|string|max:255|unique:product_variants,sku',
            'variants.*.price' => 'required_with:variants|numeric|min:0',
            'variants.*.stock' => 'required_with:variants|integer|min:0',
            'variants.*.weight' => 'nullable|numeric|min:0',
            'variants.*.status' => 'nullable|string',
            'images' => 'nullable|array',
            'images.*' => 'image|mimes:jpeg,png,jpg,webp|max:2048',
        ];
    }
}
