<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Guaranty extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = ['title'];

    public static function createGuaranty($request): void
    {
        Guaranty::create([
            'title' => $request->title,
        ]);
    }

    public static function updateGuaranty($request, $id)
    {
        $guaranty = self::findOrFail($id);
        $data = [
            'title' => $request->input('title'),
        ];
        $guaranty->update($data);

        return $guaranty;
    }
}
