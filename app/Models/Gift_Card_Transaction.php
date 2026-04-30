<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Gift_Card_Transaction extends Model
{
    protected $table = 'gift_card_transactions';

    protected $fillable = [
        'gift_card_id', 'order_id', 'amount', 'type'
    ];

    protected $casts = [
        'amount' => 'decimal:2',
    ];

    public function giftCard()
    {
        return $this->belongsTo(Gift_card::class);
    }

    public function order()
    {
        return $this->belongsTo(Order::class);
    }
}
