<?php

namespace App\Http\Controllers\Admin;

use App\Helpers\ImageHelper;
use App\Http\Controllers\Controller;
use App\Models\Brand;
use App\Models\Category;
use App\Models\Gallery;
use App\Models\Product;
use App\Models\Property;
use App\Models\PropertyGroup;
use App\Models\Tag;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Intervention\Image\Drivers\Gd\Driver;
use Intervention\Image\ImageManager;


class ProductController extends Controller
{
    public function index()
    {
        $categories = Category::query()->paginate(12);
        $products = Product::query()->paginate(12);
        $title = 'لیست دسته بندی ها';
        return view('admin.products.list', compact('title', 'products', 'categories'));
    }


    public function create()
    {
        $categories = Category::getCategory();
        $tags = Tag::query()->pluck('title', 'id');
        $brands = Brand::query()->pluck('title', 'id');
        $title = 'ایجاد دسته بندی ها';
        return view('admin.products.create', compact('title', 'brands', 'tags', 'categories'));
    }


    public function store(Request $request)
    {
        Product::CreateProduct($request);
        return redirect()->route('products.index')->with('message', 'محصول با موفقیت افزوده شد');
    }

    public function show(string $id)
    {
        //
    }


    public function edit(string $id)
    {
        $title = 'ویرایش دسته بندی ها';
        $product = Product::with('tags')->findOrFail($id);

        $categories = Category::pluck('title', 'id');
        $brands = Brand::pluck('title', 'id');
        $tags = Tag::pluck('title', 'id');

        return view('admin.products.edit', compact(
            'product', 'categories', 'brands', 'tags'
        ));
    }


    public function update(Request $request, $id)
    {
        $product = Product::findOrFail($id);

        $product->update([
            'title' => $request->title,
            'etitle' => $request->etitle,
            'description' => $request->description,
            'price' => $request->price,
            'category_id' => $request->category,
            'brand_id' => $request->brand,
        ]);

        $product->tags()->sync($request->tags ?? []);

        return redirect()->route('products.index')
            ->with('message', 'محصول با موفقیت ویرایش شد');
    }


    public function destroy(Product $product)
    {
        if ($product->trashed()) {

            if ($product->image) {
                Storage::disk('public')->delete('products/' . $product->image);
            }

            $product->forceDelete();
            $msg = 'محصول به طور کامل حذف شد';

        } else {

            $product->delete();
            $msg = 'محصول به سطل زباله منتقل شد';

        }

        return back()->with('message', $msg);
    }

    public function trashed()
    {
        $title = 'سطل زباله - دسته بندی ها';

        $products = \App\Models\Product::onlyTrashed()
            ->latest()
            ->paginate(10);

        return view('admin.products.trashed_list', compact('title', 'products'));
    }

    public function forceDelete($id)
    {
        $product = Product::onlyTrashed()->findOrFail($id);

        if ($product->image) {
            Storage::disk('public')->delete('products/' . $product->image);
        }

        $product->forceDelete();

        return redirect()->back()->with('success', 'محصول کاملاً حذف شد');
    }

    public function restore($id)
    {
        $product = Product::onlyTrashed()->findOrFail($id);
        $product->restore();

        return redirect()->back()->with('success', 'محصول با موفقیت بازیابی شد');
    }

    public function createGallery($id)
    {
        $product = Product::query()->find($id);
        $galleries = Gallery::where('product_id', $product->id)->get();
        return view('admin.products.create_gallery', compact('product', 'galleries'));
    }


    public function storeGallery(Request $request, Product $product)
    {
        $request->validate([
            'file' => 'required|image|mimes:jpg,jpeg,png,webp|max:2048'
        ]);

        $image = ImageHelper::upload($request->file('file'), 'products/gallery');

        Gallery::create([
            'product_id' => $product->id,
            'image' => $image,
            'position' => 0
        ]);

        return response()->json(['success' => true]);
    }

    public function destroyGallery(Product $product, Gallery $gallery)
    {
        $gallery->delete();

        return back()->with('message', 'تصویر حذف شد');
    }

    public function CreateProductProperty(Product $product)
    {
        $property_groups = PropertyGroup::all();

        $properties = Property::with('propertyGroup')
            ->where('product_id', $product->id)
            ->get();

        return view('admin.products.product_properties', compact(
            'product',
            'property_groups',
            'properties'
        ));
    }

    public function DestroyProperty($id)
    {
        $property = Property::findOrFail($id);
        $property->delete();

        return back()->with('message', 'ویژگی حذف شد');
    }


    public function StoreProductProperty(Request $request, $product_id)
    {
        $request->validate([
            'title' => 'required',
            'property_group_id' => 'required'
        ]);

        Property::create([
            'title' => $request->title,
            'product_id' => $product_id,
            'property_group_id' => $request->property_group_id
        ]);

        return back()->with('message', 'ویژگی با موفقیت ایجاد شد');
    }

    public function EditProperty($id)
    {
        $property = Property::findOrFail($id);

        $property_groups = PropertyGroup::all();

        return view('admin.products.edit_product_properties', compact(
            'property',
            'property_groups'
        ));
    }

    public function UpdateProperty(Request $request, $id)
    {
        $request->validate([
            'title' => 'required',
            'property_group_id' => 'required'
        ]);

        $property = Property::findOrFail($id);

        $property->update([
            'title' => $request->title,
            'property_group_id' => $request->property_group_id
        ]);

        return redirect()
            ->route('create.product.properties', ['product' => $property->product_id])
            ->with('message', 'ویژگی با موفقیت ویرایش شد');
    }

}
