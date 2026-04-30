<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Address extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'title',
        'type',
        'recipient_name',
        'recipient_phone',
        'address',
        'city',
        'state',
        'postcode',
        'country',
        'plaque',
        'unit',
        'order_number',
        'is_default'
    ];

    protected $casts = [
        'is_default' => 'boolean',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function setAsDefault()
    {
        $this->user->addresses()->update(['is_default' => false]);
        $this->update(['is_default' => true]);
    }
}
