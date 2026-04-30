<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PaymentGateway extends Model
{
    protected $fillable = ['name', 'title', 'is_active', 'config'];

    protected $casts = [
        'config' => 'array',
        'is_active' => 'boolean'
    ];

    public static function boot()
    {
        parent::boot();

        static::saving(function ($model) {
            $model->name = strtolower(trim($model->name));
        });
    }
}
