<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Discount extends Model
{
//    use SoftDeletes;

    protected $table = 'discounts';

    protected $fillable = [
        'code',
        'type',
        'value',
        'min_order_amount',
        'max_discount_amount',
        'usage_limit',
        'used_count',
        'starts_at',
        'expires_at',
        'is_active',
        'description'
    ];

    protected $casts = [
        'starts_at' => 'datetime',
        'expires_at' => 'datetime',
        'is_active' => 'boolean',
        'value' => 'float',
        'min_order_amount' => 'float',
        'max_discount_amount' => 'float',
        'usage_limit' => 'integer',
        'used_count' => 'integer',
    ];

    /**
     * بررسی اعتبار کد تخفیف
     */
    public function isValid(): bool
    {
        // بررسی فعال بودن
        if (!$this->is_active) {
            return false;
        }

        // بررسی تاریخ شروع
        if ($this->starts_at && $this->starts_at->isFuture()) {
            return false;
        }

        // بررسی تاریخ انقضا
        if ($this->expires_at && $this->expires_at->isPast()) {
            return false;
        }

        // بررسی تعداد دفعات استفاده
        if ($this->usage_limit && $this->used_count >= $this->usage_limit) {
            return false;
        }

        return true;
    }

    /**
     * محاسبه مبلغ تخفیف
     */
    public function calculateDiscount($subtotal): float
    {
        // اگر کد تخفیف معتبر نیست
        if (!$this->isValid()) {
            return 0;
        }

        // بررسی حداقل مبلغ سفارش
        if ($this->min_order_amount && $subtotal < $this->min_order_amount) {
            return 0;
        }

        // محاسبه تخفیف بر اساس نوع
        if ($this->type === 'percent') {
            $discount = ($subtotal * $this->value) / 100;
        } else { // نوع مبلغ ثابت
            $discount = $this->value;
        }

        // اعمال حداکثر تخفیف
        if ($this->max_discount_amount && $discount > $this->max_discount_amount) {
            $discount = $this->max_discount_amount;
        }

        // تخفیف نمی‌تواند از مبلغ کل بیشتر باشد
        return min($discount, $subtotal);
    }

    /**
     * افزایش تعداد استفاده
     */
    public function incrementUsedCount(): void
    {
        $this->increment('used_count');
    }

    /**
     * بررسی قابلیت استفاده
     */
    public function isUsable(): bool
    {
        return $this->isValid();
    }

    /**
     * Scope برای تخفیف‌های فعال
     */
    public function scopeActive($query)
    {
        return $query->where('is_active', true)
            ->where(function ($q) {
                $q->whereNull('expires_at')
                    ->orWhere('expires_at', '>', now());
            });
    }

    /**
     * Scope برای تخفیف‌های منقضی شده
     */
    public function scopeExpired($query)
    {
        return $query->where('expires_at', '<', now());
    }

    /**
     * دریافت متن نوع تخفیف
     */
    public function getTypeTextAttribute(): string
    {
        return $this->type === 'percent' ? 'درصدی' : 'مبلغ ثابت';
    }

    /**
     * دریافت متن وضعیت
     */
    public function getStatusTextAttribute(): string
    {
        if (!$this->is_active) {
            return 'غیرفعال';
        }

        if ($this->expires_at && $this->expires_at->isPast()) {
            return 'منقضی شده';
        }

        if ($this->starts_at && $this->starts_at->isFuture()) {
            return 'در انتظار';
        }

        return 'فعال';
    }

    /**
     * دریافت مقدار تخفیف به صورت فرمت شده
     */
    public function getFormattedValueAttribute(): string
    {
        if ($this->type === 'percent') {
            return number_format($this->value) . '%';
        }

        return number_format($this->value) . ' تومان';
    }
}
