<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Cart extends Model
{
    protected $fillable = [
        'user_id',
        'product_id',
        'variant_id',  // اضافه شد
        'color_id',
        'guaranty_id',
        'quantity',
        'price'  // اضافه شد برای ذخیره قیمت
    ];

    protected $casts = [
        'quantity' => 'integer',
        'price' => 'decimal:0'
    ];

    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    public function color()
    {
        return $this->belongsTo(Color::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function productVariant()
    {
        return $this->belongsTo(ProductVariant::class, 'variant_id');
    }

    public function guaranty()
    {
        return $this->belongsTo(Guaranty::class);
    }

    // محاسبه قیمت کل آیتم
    public function getTotalPriceAttribute()
    {
        return $this->price * $this->quantity;
    }
}
