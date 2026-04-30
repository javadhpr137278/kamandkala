<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Color extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = ['name', 'code'];

    public function products()
    {
        return $this->belongsToMany(Product::class,'color_product');
    }

    public static function CreateColor($request): void
    {
        Color::create([
            'name' => $request->name,
            'code' => $request->code,
        ]);
    }

    public static function updateColor($request, $id)
    {
        $color = self::findOrFail($id);

        $data = [
            'name' => $request->input('name'),
            'code' => $request->input('code'),
        ];

        $color->update($data);

        return $color;
    }

    public function variants()
    {
        return $this->hasMany(ProductVariant::class);
    }

}
