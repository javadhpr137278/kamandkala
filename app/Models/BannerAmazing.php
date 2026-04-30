<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BannerAmazing extends Model
{
    use HasFactory;
    protected $fillable = [
        'title',
        'festival_title',
        'festival_description',
        'discount_percent',
        'start_date',
        'end_date',
        'image',
        'colors',
        'button_text',
        'button_link',
        'countdown_end'
    ];

    protected $casts = [
        'colors' => 'array',
        'countdown_end' => 'datetime'
    ];
}

