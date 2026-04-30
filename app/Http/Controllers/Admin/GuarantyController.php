<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Guaranty;
use Illuminate\Http\Request;

class GuarantyController extends Controller
{
    /**
     * Display a listing of the resource.
     */

    public function index()
    {
        $guaranties = Guaranty::query()->paginate(10);
        $title = 'لیست گارانتی ها';
        return view('admin.guaranties.list',compact('title', 'guaranties'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $title = 'ایجاد گارانتی ها';
        return view('admin.guaranties.create',compact('title'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        Guaranty::createGuaranty($request);
        return redirect()->route('guaranties.index')->with('message', 'گارانتی با موفقیت افزوده شد');
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
        $title = 'ویرایش گارانتی ها';
        $guaranty = Guaranty::findOrfail($id);

        return view('admin.guaranties.edit', compact('title',  'guaranty'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        Guaranty::updateGuaranty($request, $id);

        return redirect()->route('guaranties.index')
            ->with('message', 'گارانتی با موفقیت ویرایش شد');
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Guaranty $guaranty)
    {
        if ($guaranty->trashed()) {
            $guaranty->forceDelete();
            $msg = 'گارانتی به طور کامل حذف شد';

        } else {

            $guaranty->delete();
            $msg = 'گارانتی به سطل زباله منتقل شد';

        }

        return back()->with('message', $msg);
    }

    public function trashed()
    {
        $title = 'سطل زباله - گارانتی ها';

        $guaranties = \App\Models\Guaranty::onlyTrashed()
            ->latest()
            ->paginate(10);

        return view('admin.guaranties.trashed_list', compact('title', 'guaranties'));
    }

    public function forceDelete($id)
    {
        $guaranty = Guaranty::onlyTrashed()->findOrFail($id);
        $guaranty->forceDelete();

        return redirect()->back()->with('success', 'گارانتی کاملاً حذف شد');
    }

    public function restore($id)
    {
        $guaranty = Guaranty::onlyTrashed()->findOrFail($id);
        $guaranty->restore();

        return redirect()->back()->with('success', 'گارانتی با موفقیت بازیابی شد');
    }
}
