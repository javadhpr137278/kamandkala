<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class VerificationCode extends Model
{
    use HasFactory;

    protected $fillable = [
        'mobile',
        'email',
        'code',
    ];

    public static function CheckTwoMinutes($entry): bool
    {
        $check = self::query()->where('mobile', $entry)
            ->orWhere('email', $entry)
            ->where('created_at', '>', Carbon::now()->subMinute(2))->first();
        if ($check) {
            return true;
        }
        return false;
    }

    public static function VerificationCode($entry, $code)
    {
        self::query()->create([
            'mobile' => $entry,
            'code' => $code
        ]);
    }

    public static function CheckVerificationCode($entry, $code): bool
    {
        $check = self::query()->where('mobile', $entry)
            ->orWhere('email', $entry)
            ->where('code', $code)->first();
        if ($check) {
            return true;
        }
        return false;
    }
}
