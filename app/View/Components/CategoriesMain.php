<?php

namespace App\View\Components;

use App\Models\Category;
use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class CategoriesMain extends Component
{
    /**
     * دسته‌بندی‌ها که به ویو پاس می‌دیم
     *
     * @var \Illuminate\Database\Eloquent\Collection
     */
    public $categories;

    public function __construct()
    {
        // فقط دسته‌های والد (parent_id = 0) را با زیرمجموعه‌ها و محصولات می‌گیریم
        $this->categories = Category::query()
            ->with(['childCategory', 'products']) // اگر ساختار دیگه‌ای داری تنظیم کن
            ->where('parent_id', 0)
            ->get();
    }

    public function render(): View|Closure|string
    {
        return view('components.categories-main');
    }
}
