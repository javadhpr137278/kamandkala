<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PropertyGroup extends Model
{
    use HasFactory;

    protected $fillable = [
        'category_id',
        'title',
    ];

    public function category()
    {
        return $this->belongsTo(Category::class);

    }
    public function properties()
    {
        return $this->hasMany(Property::class);
    }
    public function products()
    {
        return $this->belongsToMany(
            Product::class,
            'product_property_group',
            'property_groups_id',
            'product_id'
        );
    }

}
