<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    // نمایش لیست دسته‌بندی‌ها
    public function index()
    {
        $categories = Category::with('parent')->paginate(12);
        return view('admin.categories.list', compact('categories'));
    }

    // نمایش فرم ایجاد دسته‌بندی
    public function create()
    {
        $categories = Category::where('parent_id', 0)->get();
        return view('admin.categories.create', compact('categories'));
    }

    // ذخیره دسته‌بندی جدید
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'parent_id' => 'nullable|exists:categories,id'
        ]);

        Category::create($request->all());

        return redirect()->route('categories.index')
            ->with('success', 'دسته‌بندی با موفقیت ایجاد شد');
    }

    // نمایش فرم ویرایش
    public function edit($id)
    {
        $category = Category::findOrFail($id);
        $categories = Category::where('parent_id', 0)->get();
        return view('admin.categories.edit', compact('category', 'categories'));
    }

    // بروزرسانی دسته‌بندی
    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'parent_id' => 'nullable|exists:categories,id'
        ]);

        $category = Category::findOrFail($id);
        $category->update($request->all());

        return redirect()->route('categories.index')
            ->with('success', 'دسته‌بندی با موفقیت بروزرسانی شد');
    }

    // حذف دسته‌بندی (حذف فیزیکی از دیتابیس)
    public function destroy($id)
    {
        $category = Category::findOrFail($id);

        // بررسی زیرمجموعه‌ها
        if($category->children()->count() > 0) {
            return redirect()->route('categories.index')
                ->with('error', 'این دسته‌بندی دارای زیرمجموعه است، ابتدا زیرمجموعه‌ها را حذف کنید');
        }

        $category->delete(); // حذف فیزیکی

        return redirect()->route('categories.index')
            ->with('success', 'دسته‌بندی با موفقیت حذف شد');
    }
}
