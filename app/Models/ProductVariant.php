<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ProductVariant extends Model
{
    use SoftDeletes;

    protected $table = 'product_variants';

    protected $fillable = [
        'product_id',
        'color_id',
        'guaranty_id',
        'main_price',
        'discount_price',
        'discount_percent',
        'stock',
        'max_sell',
        'sku',
        'is_special',
        'special_expiration',
    ];

    protected $casts = [
        'is_special' => 'boolean',
        'special_expiration' => 'datetime',
        'main_price' => 'float',
        'discount_price' => 'float',
    ];

    /* -------------------- Relationships -------------------- */

    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    public function color()
    {
        return $this->belongsTo(Color::class);
    }


    public function guaranty()
    {
        return $this->belongsTo(Guaranty::class);
    }

    /* -------------------- Accessors -------------------- */

    // قیمت نهایی (اگر discount_price صفر بود محاسبه شود)
    public function getFinalPriceAttribute()
    {
        if ($this->discount_price > 0) {
            return $this->discount_price;
        }

        $discount = ($this->main_price * $this->discount_percent) / 100;
        return $this->main_price - $discount;
    }

    /* -------------------- Helpers -------------------- */

    public static function calculateDiscountPrice($price, $percent)
    {
        $discount = ($price * $percent) / 100;
        return $price - $discount;
    }
}
