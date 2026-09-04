<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BeforeAfterCase extends Model
{
    use HasFactory;

    protected $table = 'before_after_cases';

    protected $fillable = [
        'case_title',
        'image_path',
        'doctor_or_branch',
        'hashtag',
        'description',
        'order',
        'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'order'     => 'integer',
    ];
}
