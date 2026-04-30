<?php

namespace App\Models;

use App\Helpers\ImageHelper;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Storage;

class Category extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'etitle',
        'slug',
        'parent_id',
        'image'
    ];

    // رابطه برای دسته‌بندی والد
    public function parent()
    {
        return $this->belongsTo(Category::class, 'parent_id');
    }

    // رابطه برای زیردسته‌ها
    public function children()
    {
        return $this->hasMany(Category::class, 'parent_id');
    }

    public function childCategory()
    {
        return $this->hasMany(Category::class, 'parent_id');
    }

    // اسکوپ برای گرفتن دسته‌های اصلی (والدها)
    public function scopeParents($query)
    {
        return $query->where('parent_id', 0);
    }
    // Accessor برای دریافت آدرس کامل تصویر
    public function getImageUrlAttribute()
    {
        if ($this->image && Storage::disk('public')->exists($this->image)) {
            return Storage::url($this->image);
        }
        return null;
    }

    // Mutator برای حذف تصویر قدیمی هنگام آپلود جدید
    public function setImageAttribute($value)
    {
        if ($value && $this->image && $value !== $this->image) {
            ImageHelper::delete($this->image);
        }
        $this->attributes['image'] = $value;
    }
    public function products()
    {
        return $this->hasMany(Product::class); // فرض می‌کنیم مدل Product وجود دارد
    }
    public static function getCategory()
    {
        $categories = self::with('childCategory')->where('parent_id', 0)->get();
        $result = [];

        foreach ($categories as $category) {
            $result[$category->id] = $category;
            foreach ($category->childCategory as $child) {
                $result[$child->id] = $child;
                foreach ($child->childCategory as $grandChild) {
                    $result[$grandChild->id] = $grandChild;
                }
            }
        }

        return $result;
    }
}



