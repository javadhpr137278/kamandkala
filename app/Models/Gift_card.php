<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Gift_card extends Model
{
    use SoftDeletes;

    protected $table = 'gift_cards';

    protected $fillable = [
        'code',
        'initial_balance',
        'current_balance',
        'expires_at',
        'is_active',
        'user_id',
        'used_at'
    ];

    protected $casts = [
        'expires_at' => 'datetime',
        'is_active' => 'boolean',
        'initial_balance' => 'float',
        'current_balance' => 'float',
        'used_at' => 'datetime'
    ];

    /**
     * بررسی اعتبار کارت هدیه
     */
    public function isValid(): bool
    {
        if (!$this->is_active) {
            return false;
        }

        if ($this->current_balance <= 0) {
            return false;
        }

        if ($this->expires_at && $this->expires_at->isPast()) {
            return false;
        }

        return true;
    }

    /**
     * استفاده از کارت هدیه
     */
    public function use($amount): bool
    {
        if (!$this->isValid() || $amount > $this->current_balance) {
            return false;
        }

        $this->current_balance -= $amount;

        if ($this->current_balance == 0) {
            $this->is_active = false;
            $this->used_at = now();
        }

        $this->save();

        return true;
    }
}
