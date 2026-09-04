<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use App\Models\ProductImage;
use App\Models\Review; // Pastikan Model Review di-import

class Product extends Model {
    use HasFactory;

    protected $guarded = ['id'];
    protected $casts = ['seo_metadata' => 'array'];

    protected $fillable = [
        'name',
        'slug',
        'category_id',
        'sku',
        'price',
        'weight',
        'stock',
        'status',
        'description',
        'recommended_for',
        'benefits',
        'skin_concerns',
        'how_to_use',
        'ingredients',
    ];

    public function category(): BelongsTo {
        return $this->belongsTo(Category::class);
    }

    public function variants(): HasMany {
        return $this->hasMany(ProductVariant::class);
    }

    public function images() {
        return $this->hasMany(ProductImage::class, 'product_id');
    }

    // --- RELASI KE REVIEW / ULASAN ---
    public function reviews(): HasMany {
        return $this->hasMany(Review::class, 'product_id');
    }

    // --- FUNGSI MENGHITUNG RATA-RATA RATING ---
    public function averageRating() {
        return $this->reviews()->avg('rating') ?: 0;
    }
}
