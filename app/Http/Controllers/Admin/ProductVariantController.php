<?php


namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\ProductVariant;
use App\Models\Color;
use App\Models\Guaranty;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class ProductVariantController extends Controller
{

    public function index(Product $product)
    {
        $variants = ProductVariant::with(['color','guaranty'])
            ->where('product_id',$product->id)
            ->latest()
            ->paginate(15);

        return view('admin.product_variants.list',compact(
            'variants',
            'product'
        ));
    }



    public function create($product_id)
    {
        $product = Product::findOrFail($product_id);
        $variant = new ProductVariant();
        $colors = Color::all();
        $guaranties = Guaranty::all();

        $title = 'ایجاد تنوع محصول';

        return view('admin.product_variants.create', compact(
            'product',
            'colors',
            'guaranties',
            'title',
            'variant'
        ));
    }


    public function store(Request $request, $product_id)
    {
        $request->validate([
            'color_id' => 'required|exists:colors,id',
            'guaranty_id' => 'nullable|exists:guaranties,id',
            'main_price' => 'required|numeric',
            'discount_percent' => 'nullable|numeric|max:100',
            'stock' => 'required|integer',
            'max_sell' => 'nullable|integer',
        ]);

        $discountPercent = $request->discount_percent ?? 0;
        $discountPrice = ProductVariant::calculateDiscountPrice(
            $request->main_price,
            $discountPercent
        );

        ProductVariant::create([
            'product_id' => $product_id,
            'color_id' => $request->color_id,
            'guaranty_id' => $request->guaranty_id,
            'main_price' => $request->main_price,
            'discount_percent' => $discountPercent,
            'discount_price' => $discountPrice,
            'stock' => $request->stock,
            'max_sell' => $request->max_sell,
            'sku' => 'KM-' . str_pad(random_int(0, 99999999), 4, '0', STR_PAD_LEFT),
            'is_special' => $request->has('is_special'),
            'special_expiration' => $request->has('is_special') ? $request->special_expiration : null,
        ]);

        return redirect()->back()
            ->with('success', 'تنوع محصول ایجاد شد');
    }


    public function edit(Product $product, ProductVariant $variant)
    {
        $colors = Color::all();
        $guaranties = Guaranty::all();

        return view('admin.product_variants.edit', compact(
            'product',
            'variant',
            'colors',
            'guaranties'
        ));
    }




    public function update(Request $request, $id)
    {
        $variant = ProductVariant::findOrFail($id);

        $request->validate([
            'color_id' => 'required|exists:colors,id',
            'guaranty_id' => 'nullable|exists:guaranties,id',
            'main_price' => 'required|numeric',
            'discount_percent' => 'nullable|numeric|max:100',
            'stock' => 'required|integer',
        ]);

        $discountPercent = $request->discount_percent ?? 0;

        $discountPrice = ProductVariant::calculateDiscountPrice(
            $request->main_price,
            $discountPercent
        );

        $variant->update([
            'color_id' => $request->color_id,
            'guaranty_id' => $request->guaranty_id,
            'main_price' => $request->main_price,
            'discount_percent' => $discountPercent,
            'discount_price' => $discountPrice,
            'stock' => $request->stock,
            'max_sell' => $request->max_sell,
            'is_special' => $request->has('is_special'),
            'special_expiration' => $request->has('is_special') ? $request->special_expiration : null,
        ]);

        return redirect()->back()
            ->with('success', 'تنوع محصول بروزرسانی شد');
    }


    public function destroy($id)
    {
        $variant = ProductVariant::findOrFail($id);

        $variant->delete();

        return redirect()->back()
            ->with('success', 'تنوع محصول حذف شد');
    }
}
