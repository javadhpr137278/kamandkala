<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Tag;
use Illuminate\Http\Request;

class TagController extends Controller
{
    /**
     * Display a listing of the resource.
     */

    public function index()
    {
        $tags = Tag::query()->paginate(10);
        $title = 'لیست تگ ها';
        return view('admin.tags.list',compact('title', 'tags'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $title = 'ایجاد تگ ها';
        return view('admin.tags.create',compact('title'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        Tag::CreateTag($request);
        return redirect()->route('tags.index')->with('message', 'تگ با موفقیت افزوده شد');
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
        $title = 'ویرایش تگ ها';
        $tag = Tag::findOrfail($id);

        return view('admin.tags.edit', compact('title',  'tag'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        Tag::updateTag($request, $id);

        return redirect()->route('tags.index')
            ->with('message', 'تگ با موفقیت ویرایش شد');
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Tag $tag)
    {
        if ($tag->trashed()) {
            $tag->forceDelete();
            $msg = 'تگ به طور کامل حذف شد';

        } else {

            $tag->delete();
            $msg = 'تگ به سطل زباله منتقل شد';

        }

        return back()->with('message', $msg);
    }

    public function trashed()
    {
        $title = 'سطل زباله - تگ ها';

        $tags = \App\Models\Tag::onlyTrashed()
            ->latest()
            ->paginate(10);

        return view('admin.tags.trashed_list', compact('title', 'tags'));
    }

    public function forceDelete($id)
    {
        $tag = Tag::onlyTrashed()->findOrFail($id);
        $tag->forceDelete();

        return redirect()->back()->with('success', 'تگ کاملاً حذف شد');
    }

    public function restore($id)
    {
        $tag = Tag::onlyTrashed()->findOrFail($id);
        $tag->restore();

        return redirect()->back()->with('success', 'تگ با موفقیت بازیابی شد');
    }
}
