<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Brand;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class BrandController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $brands = Brand::query()->paginate(10);
        $title = 'لیست برند ها';
        return view('admin.brands.list',compact('title', 'brands'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $title = 'ایجاد برند ها';
        return view('admin.brands.create',compact('title'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        Brand::CreateBrand($request);
        return redirect()->route('brands.index')->with('message', 'برند با موفقیت افزوده شد');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $title = 'ویرایش برند ها';
        $brand = Brand::findOrfail($id);

        return view('admin.brands.edit', compact('title',  'brand'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $brand = Brand::query()->find($id);
        Brand::UpdateBrand($request, $brand);
        return redirect()->route('brands.index')->with('message', 'برند با موفقیت ویرایش شد');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Brand $brand)
    {
        if ($brand->trashed()) {

            if ($brand->image) {
                Storage::disk('public')->delete('brands/' . $brand->image);
            }

            $brand->forceDelete();
            $msg = 'برند به طور کامل حذف شد';

        } else {

            $brand->delete();
            $msg = 'برند به سطل زباله منتقل شد';

        }

        return back()->with('message', $msg);
    }

    public function trashed()
    {
        $title = 'سطل زباله - برند ها';

        $brands = \App\Models\Brand::onlyTrashed()
            ->latest()
            ->paginate(10);

        return view('admin.brands.trashed_list', compact('title', 'brands'));
    }

    public function forceDelete($id)
    {
        $brand = Brand::onlyTrashed()->findOrFail($id);

        if ($brand->image) {
            Storage::disk('public')->delete('brands/' . $brand->image);
        }

        $brand->forceDelete();

        return redirect()->back()->with('success', 'برند کاملاً حذف شد');
    }

    public function restore($id)
    {
        $brand = Brand::onlyTrashed()->findOrFail($id);
        $brand->restore();

        return redirect()->back()->with('success', 'برند با موفقیت بازیابی شد');
    }
}
