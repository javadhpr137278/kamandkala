<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphTo;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Payment extends Model
{
    protected $table = 'payments';

    protected $fillable = [
        'user_id',
        'transaction_id',
        'order_id',
        'amount',
        'gateway',
        'status',
        'reference_id',
        'tracking_code',
        'card_number',
        'payment_data',
        'description',
        'metadata',
        'paid_at',
        'verified_at'
    ];

    protected $casts = [
        'amount' => 'decimal:0',
        'payment_data' => 'array',
        'metadata' => 'array',
        'paid_at' => 'datetime',
        'verified_at' => 'datetime',
    ];

    // وضعیت‌های پرداخت
    const STATUS_PENDING = 'pending';
    const STATUS_PROCESSING = 'processing';
    const STATUS_COMPLETED = 'completed';
    const STATUS_FAILED = 'failed';
    const STATUS_REFUNDED = 'refunded';

    // روابط
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function order(): BelongsTo
    {
        return $this->belongsTo(Order::class);
    }

    // متدهای کمکی
    public function isPending(): bool
    {
        return $this->status === self::STATUS_PENDING;
    }

    public function isCompleted(): bool
    {
        return $this->status === self::STATUS_COMPLETED;
    }

    public function isFailed(): bool
    {
        return $this->status === self::STATUS_FAILED;
    }

    public function markAsProcessing(): void
    {
        $this->update([
            'status' => self::STATUS_PROCESSING,
        ]);
    }

    public function markAsCompleted(string $referenceId, array $data = []): void
    {
        $this->update([
            'status' => self::STATUS_COMPLETED,
            'reference_id' => $referenceId,
            'tracking_code' => $data['tracking_code'] ?? null,
            'card_number' => $data['card_number'] ?? null,
            'payment_data' => array_merge($this->payment_data ?? [], $data),
            'verified_at' => now(),
        ]);
    }

    public function markAsFailed(array $data = []): void
    {
        $this->update([
            'status' => self::STATUS_FAILED,
            'payment_data' => array_merge($this->payment_data ?? [], $data),
        ]);
    }

    public function markAsRefunded(): void
    {
        $this->update(['status' => self::STATUS_REFUNDED]);
    }

    public function getStatusBadgeAttribute(): string
    {
        $badges = [
            self::STATUS_PENDING => 'warning',
            self::STATUS_PROCESSING => 'info',
            self::STATUS_COMPLETED => 'success',
            self::STATUS_FAILED => 'danger',
            self::STATUS_REFUNDED => 'secondary',
        ];

        $texts = [
            self::STATUS_PENDING => 'در انتظار پرداخت',
            self::STATUS_PROCESSING => 'در حال پردازش',
            self::STATUS_COMPLETED => 'پرداخت شده',
            self::STATUS_FAILED => 'ناموفق',
            self::STATUS_REFUNDED => 'استرداد شده',
        ];

        $color = $badges[$this->status] ?? 'secondary';
        $text = $texts[$this->status] ?? $this->status;

        return "<span class='badge badge-{$color}'>{$text}</span>";
    }
}
