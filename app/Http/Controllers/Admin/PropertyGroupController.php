<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Brand;
use App\Models\Category;
use App\Models\Product;
use App\Models\PropertyGroup;
use App\Models\Tag;
use Illuminate\Http\Request;

class PropertyGroupController extends Controller
{
    public function index()
    {
        $title = 'لیست گروه ویژگی ها';

        $property_groups = PropertyGroup::with('category')->get();

        $categories = Category::query()->where('parent_id',[0])->pluck('title', 'id');

        return view('admin.property_groups.list',
            compact('title', 'property_groups', 'categories')
        );
    }


    public function create()
    {
        $categories = Category::getCategory();
        $title = 'ایجاد گروه ویژگی ها';
        return view('admin.property_groups.create', compact('title', 'categories'));
    }


    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'category_id' => 'required|exists:categories,id'
        ]);

        PropertyGroup::create([
            'title' => $request->title,
            'category_id' => $request->category_id
        ]);

        return redirect()
            ->route('property_group.index')
            ->with('message', 'گروه ویژگی با موفقیت ایجاد شد');
    }


    public function show(string $id)
    {
        //
    }


    public function edit(string $id)
    {
        $title = 'ویرایش دسته بندی ها';
        $property_groups = PropertyGroup::findOrFail($id);

        $categories = Category::query()->where('parent_id',[0])->pluck('title', 'id');

        return view('admin.property_groups.edit', compact(
            'property_groups', 'categories'
        ));
    }


    public function update(Request $request, $id)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'category_id' => 'required|exists:categories,id'
        ]);

        $property_group = PropertyGroup::findOrFail($id);

        $property_group->update([
            'title' => $request->title,
            'category_id' => $request->category_id
        ]);

        return redirect()
            ->route('property_group.index')
            ->with('message', 'گروه ویژگی با موفقیت بروزرسانی شد');
    }


    public function destroy($id)
    {
        $property_group = PropertyGroup::findOrFail($id);

        $property_group->delete();

        return redirect()
            ->back()
            ->with('message','گروه ویژگی با موفقیت حذف شد');
    }


}
