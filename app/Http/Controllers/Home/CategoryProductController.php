<?php

namespace App\Http\Controllers\Home;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Product;
use App\Enums\ProductStatus;
use Illuminate\Http\Request;

class CategoryProductController extends Controller
{
    /**
     * Display a listing of all categories.
     */
    public function index()
    {
        // Get all main categories (parent_id = 0) with their products count
        $categories = Category::withCount('products')
            ->where('parent_id', 0)
            ->get();

        // Get latest products for the best seller section
        $latest_products = Product::where('status', ProductStatus::Available->value)
            ->with(['category', 'productVariant'])
            ->latest()
            ->take(8)
            ->get();

        return view('home.category.index', compact('categories', 'latest_products'));
    }

    /**
     * Display products for a specific category.
     */
    public function show(Request $request, $slug)
    {
        // دریافت دسته‌بندی با اسلاگ مربوطه
        $category = Category::where('slug', $slug)
            ->with(['childCategory' => function($query) {
                $query->withCount('products');
            }])
            ->firstOrFail();

        // دریافت ID دسته و زیردسته‌ها
        $categoryIds = [$category->id];

        if($category->childCategory) {
            foreach ($category->childCategory as $child) {
                $categoryIds[] = $child->id;
                if($child->childCategory) {
                    foreach ($child->childCategory as $grandChild) {
                        $categoryIds[] = $grandChild->id;
                    }
                }
            }
        }

        // دیباگ: بررسی اینکه آیا دسته‌بندی محصول دارد یا خیر
        \Log::info('Category ID: ' . $category->id);
        \Log::info('Category IDs: ' . json_encode($categoryIds));

        // ساخت کوئری محصولات
        $query = Product::whereIn('category_id', $categoryIds)
            ->where('status', ProductStatus::Available->value)
            ->with(['category', 'productVariant']);

        // دیباگ: تعداد کل محصولات قبل از فیلتر
        \Log::info('Total products before filter: ' . $query->count());

        // مرتب‌سازی
        switch ($request->get('sort')) {
            case 'price_asc':
                $query->orderBy('price', 'asc');
                break;
            case 'price_desc':
                $query->orderBy('price', 'desc');
                break;
            case 'oldest':
                $query->orderBy('created_at', 'asc');
                break;
            case 'most_sold':
                $query->orderBy('sold', 'desc');
                break;
            case 'latest':
            default:
                $query->orderBy('created_at', 'desc');
                break;
        }

        // فیلتر بر اساس قیمت (در صورت وجود رابطه productVariant)
        if ($request->has('min_price') && $request->min_price) {
            $query->whereHas('productVariant', function($q) use ($request) {
                $q->where('main_price', '>=', $request->min_price);
            });
        }

        if ($request->has('max_price') && $request->max_price) {
            $query->whereHas('productVariant', function($q) use ($request) {
                $q->where('main_price', '<=', $request->max_price);
            });
        }

        // فیلتر بر اساس برند
        if ($request->has('brand') && $request->brand) {
            $brands = explode(',', $request->brand);
            $query->whereIn('brand_id', $brands);
        }

        $products = $query->paginate(12);

        // دیباگ: تعداد محصولات نهایی
        \Log::info('Final products count: ' . $products->total());

        // دریافت دسته‌بندی‌های هم سطح
        $siblingCategories = Category::where('parent_id', $category->parent_id)
            ->withCount('products')
            ->get();

// در متد show کنترلر
        return view('home.category.show', compact('category', 'products', 'siblingCategories'));    }

    public function getBrands($slug)
    {
        try {
            $category = Category::where('slug', $slug)->firstOrFail();

            // دریافت ID دسته و زیردسته‌ها
            $categoryIds = [$category->id];

            if($category->childCategory) {
                foreach ($category->childCategory as $child) {
                    $categoryIds[] = $child->id;
                    if($child->childCategory) {
                        foreach ($child->childCategory as $grandChild) {
                            $categoryIds[] = $grandChild->id;
                        }
                    }
                }
            }

            // دریافت برندهای موجود در این دسته‌بندی
            $brands = Product::whereIn('category_id', $categoryIds)
                ->where('status', ProductStatus::Available->value)
                ->whereNotNull('brand_id')
                ->with('brand')
                ->get()
                ->pluck('brand')
                ->filter()
                ->unique('id')
                ->mapWithKeys(function ($brand) {
                    return [$brand->slug => $brand->name];
                });

            return response()->json([
                'success' => true,
                'brands' => $brands
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ], 500);
        }
    }
}
