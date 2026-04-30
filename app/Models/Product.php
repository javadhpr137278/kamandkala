<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Intervention\Image\Drivers\Gd\Driver;
use Intervention\Image\ImageManager;

class Product extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'title',
        'etitle',
        'slug',
        'image',
        'description',
        'status',
        'category_id',
        'brand_id',
    ];

    public function comments()
    {
        return $this->morphMany(Comment::class, 'commentable');
    }

    public function scopeActive($query)
    {
        return $query->where('status', \App\Enums\ProductStatus::Available->value);
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function tags()
    {
        return $this->belongsToMany(Tag::class);
    }


    public function brand()
    {
        return $this->belongsTo(Brand::class);
    }

    public function colors()
    {
        return $this->belongsToMany(Color::class, 'color_product');
    }

    public function galleries()
    {
        return $this->hasMany(Gallery::class);
    }

    public function properties()
    {
        return $this->hasMany(Property::class);
    }

    public function variants()
    {
        return $this->hasMany(ProductVariant::class);
    }

    public function productVariant()
    {
        return $this->hasMany(ProductVariant::class);
    }


    public function propertyGroups()
    {
        return $this->belongsToMany(
            PropertyGroup::class,
            'product_property_group',
            'product_id',
            'property_groups_id'
        );
    }


    public static function CreateProduct($request)
    {
        $imageName = null;

        if ($request->hasFile('image')) {
            $imageName = self::SaveImage($request->file('image')[0]);
        }

        $product = self::create([
            'title' => $request->title,
            'etitle' => $request->etitle,
            'slug' => str()->slug($request->etitle),
            'description' => $request->description,
            'price' => $request->price,
            'category_id' => $request->category,
            'brand_id' => $request->brand,
            'image' => $imageName,
        ]);

        return $product;
    }

    public function getPriceFormattedAttribute()
    {
        return number_format($this->price);
    }


    public static function SaveImage($file)
    {
        if (!$file || !$file->isValid()) {
            return null;
        }

        $manager = new ImageManager(new Driver());

        $name = Str::uuid() . '.webp';

        $image = $manager->read($file)
            ->scale(width: 800)
            ->toWebp(80);

        Storage::disk('public')->put('products/' . $name, (string)$image);

        return $name;
    }

    public function getFinalPriceAttribute()
    {
        if ($this->discount > 0) {
            return $this->price * (100 - $this->discount) / 100;
        }
        return $this->price;
    }

    public function getImageUrlAttribute()
    {
        return $this->image ? Storage::url('products/' . $this->image) : null;
    }


}
