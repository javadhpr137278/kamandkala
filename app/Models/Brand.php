<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Intervention\Image\Drivers\Gd\Driver;
use Intervention\Image\ImageManager;

class Brand extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = ['title', 'image'];

    public function products()
    {
        return $this->hasMany(Product::class);
    }

    public static function SaveImageBrand($file): ?string
    {
        if (!$file) {
            return null;
        }

        $manager = new ImageManager(new Driver());

        $name = Str::uuid() . '.webp';

        $image = $manager->read($file)
            ->scale(width: 800)
            ->toWebp(80);

        Storage::disk('public')->put('brands/' . $name, (string)$image);

        return $name;
    }

    public static function CreateBrand($request): void
    {
        Brand::create([
            'title' => $request->title,
            'image' => self::SaveImageBrand($request->file('image')),
        ]);
    }

    public static function UpdateBrand($request, $brand)
    {
        $data = [
            'title' => $request->input('title'),
        ];

        // مهم: باید hasFile چک بشه
        if ($request->hasFile('image')) {
            $data['image'] = self::SaveImageBrand($request->file('image'));
        }

        $brand->update($data);
    }
}
