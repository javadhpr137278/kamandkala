<?php
// app/Models/Order.php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Order extends Model
{
    use HasFactory;

    protected $table = 'orders';

    protected $fillable = [
        'order_number',
        'user_id',
        'billing_first_name',
        'billing_last_name',
        'billing_phone',
        'billing_email',
        'billing_address_1',
        'billing_address_2',
        'billing_city',
        'billing_state',
        'billing_postcode',
        'billing_country',
        'shipping_first_name',
        'shipping_last_name',
        'shipping_phone',
        'shipping_address_1',
        'shipping_address_2',
        'shipping_city',
        'shipping_state',
        'shipping_postcode',
        'shipping_country',
        'custom_address',
        'custom_city',
        'custom_postcode',
        'address_choice',
        'shipping_date',
        'shipping_date_persian',
        'order_items',
        'subtotal',
        'shipping_cost',
        'total',
        'payment_method',
        'status',
        'notes',
    ];

    protected $casts = [
        'order_items' => 'array',
        'shipping_date' => 'date',
        'subtotal' => 'decimal:0',
        'shipping_cost' => 'decimal:0',
        'total' => 'decimal:0',
    ];

    // متد کمکی برای دسترسی به آیتم‌ها
    public function getOrderItemsArrayAttribute()
    {
        return is_array($this->order_items) ? $this->order_items : json_decode($this->order_items, true);
    }

    // رابطه با کاربر
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    // رابطه با پرداخت
    public function payment(): HasMany
    {
        return $this->hasMany(Payment::class);
    }

    // متد کمکی برای دریافت آیتم‌های سفارش
    public function getItemsAttribute()
    {
        return json_decode($this->order_items, true);
    }

    // متد items (برای سازگاری با کدهای قبلی)
    public function items()
    {
        return json_decode($this->order_items, true);
    }

    // تولید شماره سفارش
    public static function generateOrderNumber(): string
    {
        $prefix = 'KM';
        $year = date('Y');
        $month = date('m');

        $lastOrder = self::whereYear('created_at', $year)
            ->whereMonth('created_at', $month)
            ->orderBy('id', 'desc')
            ->first();

        if ($lastOrder) {
            $lastNumber = intval(substr($lastOrder->order_number, -4));
            $newNumber = str_pad($lastNumber + 1, 4, '0', STR_PAD_LEFT);
        } else {
            $newNumber = '0001';
        }

        return "{$prefix}-{$year}{$month}-{$newNumber}";
    }

    // وضعیت سفارش به فارسی
    public function getStatusFaAttribute()
    {
        return match($this->status) {
            'pending' => 'در انتظار پرداخت',
            'processing' => 'در حال پردازش',
            'shipped' => 'ارسال شده',
            'delivered' => 'تحویل داده شده',
            'cancelled' => 'لغو شده',
            'refunded' => 'بازپرداخت شده',
            default => $this->status ?? 'نامشخص'
        };
    }

    // بدج وضعیت
    public function getStatusBadgeAttribute()
    {
        $badges = [
            'pending' => 'warning',
            'processing' => 'info',
            'completed' => 'success',
            'cancelled' => 'danger',
            'failed' => 'dark',
        ];

        $color = $badges[$this->status] ?? 'secondary';
        return "<span class='badge badge-{$color}'>{$this->status_text}</span>";
    }

    public function getAmountInRialAttribute()
    {
        return $this->total_price * 10;
    }

}
