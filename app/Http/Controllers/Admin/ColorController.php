<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Color;
use Illuminate\Http\Request;

class ColorController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $colors = Color::query()->paginate(10);
        $title = 'لیست رنگ ها';
        return view('admin.colors.list',compact('title', 'colors'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $title = 'ایجاد رنگ ها';
        return view('admin.colors.create',compact('title'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        Color::CreateColor($request);
        return redirect()->route('colors.index')->with('message', 'رنگ با موفقیت افزوده شد');
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
        $title = 'ویرایش رنگ ها';
        $color = Color::findOrfail($id);

        return view('admin.colors.edit', compact('title',  'color'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        Color::updateColor($request, $id);

        return redirect()->route('colors.index')
            ->with('message', 'رنگ با موفقیت ویرایش شد');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Color $color)
    {
        if ($color->trashed()) {

            $color->forceDelete();
            $msg = 'رنگ به طور کامل حذف شد';

        } else {

            $color->delete();
            $msg = 'رنگ به سطل زباله منتقل شد';

        }

        return back()->with('message', $msg);
    }

    public function trashed()
    {
        $title = 'سطل زباله - رنگ ها';

        $colors = \App\Models\Color::onlyTrashed()
            ->latest()
            ->paginate(10);

        return view('admin.colors.trashed_list', compact('title', 'colors'));
    }

    public function forceDelete($id)
    {
        $color = Color::onlyTrashed()->findOrFail($id);

        $color->forceDelete();

        return redirect()->back()->with('success', 'رنگ کاملاً حذف شد');
    }

    public function restore($id)
    {
        $color = Color::onlyTrashed()->findOrFail($id);
        $color->restore();

        return redirect()->back()->with('success', 'رنگ با موفقیت بازیابی شد');
    }
}
