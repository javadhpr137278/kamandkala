<?php

namespace App\Http\Controllers\Home;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Brand;
use App\Models\Category;
use App\Models\Color;
use App\Models\PropertyGroup;
use Illuminate\Http\Request;

class ShopController extends Controller
{
    public function index(Request $request)
    {
        // کوئری پایه با روابط لازم
        $query = Product::active()
            ->with([
                'category',
                'brand',
                'colors',
                'variants',
                'propertyGroups.properties'
            ])
            ->withCount('variants');

        // ========== 1. فیلتر برند ==========
        if ($request->has('brand') && !empty($request->brand)) {
            $brandSlugs = explode(',', $request->brand);
            $query->whereHas('brand', function ($q) use ($brandSlugs) {
                $q->whereIn('title', $brandSlugs);
            });
        }

        // ========== 2. فیلتر دسته‌بندی ==========
        if ($request->has('category') && !empty($request->category)) {
            $categorySlug = $request->category;
            $query->whereHas('category', function ($q) use ($categorySlug) {
                $q->where('slug', $categorySlug);
            });
        }

        // ========== 3. فیلتر رنگ (از طریق ProductVariant) ==========
        if ($request->has('color') && !empty($request->color)) {
            $colorSlugs = explode(',', $request->color);
            $query->whereHas('variants.color', function ($q) use ($colorSlugs) {
                $q->whereIn('name', $colorSlugs);
            });
        }

        // ========== 4. فیلتر ویژگی‌ها (Property Groups) ==========
        if ($request->has('properties') && !empty($request->properties)) {
            $properties = explode(',', $request->properties);
            foreach ($properties as $property) {
                $parts = explode('|', $property);
                if (count($parts) == 2) {
                    [$groupId, $propertyValue] = $parts;
                    $query->whereHas('propertyGroups', function ($q) use ($groupId, $propertyValue) {
                        $q->where('property_groups_id', $groupId)
                            ->whereHas('properties', function ($q2) use ($propertyValue) {
                                $q2->where('title', $propertyValue);
                            });
                    });
                }
            }
        }

        // ========== 5. فیلتر قیمت (اصلاح شده - بدون final_price) ==========
        if ($request->has('min_price') && is_numeric($request->min_price)) {
            $minPrice = (int) $request->min_price;
            $query->where(function ($q) use ($minPrice) {
                $q->whereHas('variants', function ($qv) use ($minPrice) {
                    // محاسبه قیمت نهایی در کوئری
                    $qv->where(function ($qvv) use ($minPrice) {
                        $qvv->where('discount_price', '>=', $minPrice)
                            ->orWhereRaw('(main_price - (main_price * discount_percent / 100)) >= ?', [$minPrice])
                            ->orWhere(function ($qvv2) use ($minPrice) {
                                $qvv2->whereNull('discount_price')
                                    ->where('main_price', '>=', $minPrice);
                            });
                    });
                })->orWhere(function ($q2) use ($minPrice) {
                    $q2->doesntHave('variants')
                        ->where('price', '>=', $minPrice);
                });
            });
        }

        if ($request->has('max_price') && is_numeric($request->max_price)) {
            $maxPrice = (int) $request->max_price;
            $query->where(function ($q) use ($maxPrice) {
                $q->whereHas('variants', function ($qv) use ($maxPrice) {
                    $qv->where(function ($qvv) use ($maxPrice) {
                        $qvv->where('discount_price', '<=', $maxPrice)
                            ->orWhereRaw('(main_price - (main_price * discount_percent / 100)) <= ?', [$maxPrice])
                            ->orWhere(function ($qvv2) use ($maxPrice) {
                                $qvv2->whereNull('discount_price')
                                    ->where('main_price', '<=', $maxPrice);
                            });
                    });
                })->orWhere(function ($q2) use ($maxPrice) {
                    $q2->doesntHave('variants')
                        ->where('price', '<=', $maxPrice);
                });
            });
        }

        // ========== 6. مرتب‌سازی ==========
        $sort = $request->get('sort', 'popular');
        switch ($sort) {
            case 'latest':
                $query->latest('id');
                break;
            case 'oldest':
                $query->oldest('id');
                break;
            case 'price_asc':
                $query->orderByRaw('COALESCE((
                    SELECT MIN(
                        CASE
                            WHEN discount_price > 0 THEN discount_price
                            WHEN discount_percent > 0 THEN main_price - (main_price * discount_percent / 100)
                            ELSE main_price
                        END
                    )
                    FROM product_variants
                    WHERE product_variants.product_id = products.id
                    AND product_variants.deleted_at IS NULL
                ), products.price) ASC');
                break;
            case 'price_desc':
                $query->orderByRaw('COALESCE((
                    SELECT MIN(
                        CASE
                            WHEN discount_price > 0 THEN discount_price
                            WHEN discount_percent > 0 THEN main_price - (main_price * discount_percent / 100)
                            ELSE main_price
                        END
                    )
                    FROM product_variants
                    WHERE product_variants.product_id = products.id
                    AND product_variants.deleted_at IS NULL
                ), products.price) DESC');
                break;
            default:
                $query->orderBy('sold', 'desc');
                break;
        }

        // ========== 7. دریافت محصولات با پیجینیشن ==========
        $products = $query->paginate(12)->withQueryString();

        // ========== 8. دریافت داده‌های سایدبار فیلتر ==========

        $brands = Brand::withCount(['products' => function ($q) {
            $q->active();
        }])->get();

        $categories = Category::withCount(['products' => function ($q) {
            $q->active();
        }])->get();

        $colors = Color::withCount(['variants' => function ($q) {
            $q->whereHas('product', function ($pq) {
                $pq->active();
            })->whereNull('product_variants.deleted_at');
        }])->get();

        $propertyGroups = PropertyGroup::with([
            'properties' => function ($q) {
                $q->withCount(['products' => function ($pq) {
                    $pq->active();
                }]);
            }
        ])->get();

        // ========== 9. محدوده قیمت برای اسلایدر (اصلاح شده) ==========
        // حداقل قیمت
        $minPriceResult = Product::active()
            ->selectRaw('MIN(COALESCE((
                SELECT MIN(
                    CASE
                        WHEN discount_price > 0 THEN discount_price
                        WHEN discount_percent > 0 THEN main_price - (main_price * discount_percent / 100)
                        ELSE main_price
                    END
                )
                FROM product_variants
                WHERE product_variants.product_id = products.id
                AND product_variants.deleted_at IS NULL
            ), products.price)) as min')
            ->first();
        $minPrice = $minPriceResult->min ?? 0;

        // حداکثر قیمت
        $maxPriceResult = Product::active()
            ->selectRaw('MAX(COALESCE((
                SELECT MAX(
                    CASE
                        WHEN discount_price > 0 THEN discount_price
                        WHEN discount_percent > 0 THEN main_price - (main_price * discount_percent / 100)
                        ELSE main_price
                    END
                )
                FROM product_variants
                WHERE product_variants.product_id = products.id
                AND product_variants.deleted_at IS NULL
            ), products.price)) as max')
            ->first();
        $maxPrice = $maxPriceResult->max ?? 100000000;

        // اگر min و max هر دو صفر بودند، مقدار پیش‌فرض بدهید
        if ($minPrice == 0 && $maxPrice == 0) {
            $minPrice = 0;
            $maxPrice = 100000000;
        }

        return view('home.shop', compact(
            'products',
            'brands',
            'categories',
            'colors',
            'propertyGroups',
            'minPrice',
            'maxPrice'
        ));
    }
}
