<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Testimonial extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'badge',
        'rating',
        'comment',
        'product_tag',
        'avatar_initial',
        'avatar_gradient',
        'order_index',
        'is_active',
    ];

    protected $casts = [
        'rating'    => 'integer',
        'order_index' => 'integer',
        'is_active' => 'boolean',
    ];

    /**
     * Dapatkan inisial nama jika avatar_initial belum diset
     */
    public function getInitialAttribute()
    {
        if (!empty($this->avatar_initial)) {
            return strtoupper($this->avatar_initial);
        }
        return strtoupper(mb_substr(trim($this->name), 0, 1));
    }
}
