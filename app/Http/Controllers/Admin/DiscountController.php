<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Discount;
use Illuminate\Http\Request;

class DiscountController extends Controller
{
    public function index()
    {
        $discounts = Discount::orderBy('id', 'desc')->paginate(20);
        return view('admin.discounts.list', compact('discounts'));
    }

    public function create()
    {
        return view('admin.discounts.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'code' => 'required|string|unique:discounts',
            'type' => 'required|in:percent,fixed',
            'value' => 'required|numeric|min:0',
            'min_order_amount' => 'nullable|numeric|min:0',
            'max_discount_amount' => 'nullable|numeric|min:0',
            'usage_limit' => 'nullable|integer|min:1',
            'starts_at' => 'nullable|date',
            'expires_at' => 'nullable|date|after:starts_at',
            'is_active' => 'boolean',
        ]);

        Discount::create($validated);

        if ($request->ajax()) {
            return response()->json(['success' => true, 'message' => 'کد تخفیف با موفقیت ایجاد شد']);
        }

        return redirect()->route('discounts.index')->with('success', 'کد تخفیف با موفقیت ایجاد شد');
    }

    public function edit(Discount $discount)
    {
        return view('admin.discounts.edit', compact('discount'));
    }

    public function update(Request $request, Discount $discount)
    {
        $validated = $request->validate([
            'code' => 'required|string|unique:discounts,code,' . $discount->id,
            'type' => 'required|in:percent,fixed',
            'value' => 'required|numeric|min:0',
            'min_order_amount' => 'nullable|numeric|min:0',
            'max_discount_amount' => 'nullable|numeric|min:0',
            'usage_limit' => 'nullable|integer|min:1',
            'starts_at' => 'nullable|date',
            'expires_at' => 'nullable|date|after:starts_at',
            'is_active' => 'boolean',
        ]);

        $discount->update($validated);

        if ($request->ajax()) {
            return response()->json(['success' => true, 'message' => 'کد تخفیف با موفقیت به‌روزرسانی شد']);
        }

        return redirect()->route('discounts.index')->with('success', 'کد تخفیف با موفقیت به‌روزرسانی شد');
    }

    public function destroy(Discount $discount, Request $request)
    {
        $discount->delete();

        if ($request->ajax()) {
            return response()->json(['success' => true, 'message' => 'کد تخفیف با موفقیت حذف شد']);
        }

        return redirect()->route('discounts.index')->with('success', 'کد تخفیف حذف شد');
    }

    public function toggleStatus(Discount $discount, Request $request)
    {
        $discount->is_active = !$discount->is_active;
        $discount->save();

        if ($request->ajax()) {
            return response()->json([
                'success' => true,
                'message' => 'وضعیت کد تخفیف با موفقیت تغییر کرد',
                'new_status' => $discount->is_active
            ]);
        }

        return back()->with('success', 'وضعیت کد تخفیف تغییر کرد');
    }

    public function trashed()
    {
        $trashedDiscounts = Discount::onlyTrashed()->paginate(20);
        return view('admin.discounts.trashed', compact('trashedDiscounts'));
    }

    public function restore($id, Request $request)
    {
        $discount = Discount::onlyTrashed()->findOrFail($id);
        $discount->restore();

        if ($request->ajax()) {
            return response()->json(['success' => true, 'message' => 'کد تخفیف با موفقیت بازیابی شد']);
        }

        return redirect()->route('discounts.index')->with('success', 'کد تخفیف بازیابی شد');
    }

    public function forceDelete($id, Request $request)
    {
        $discount = Discount::onlyTrashed()->findOrFail($id);
        $discount->forceDelete();

        if ($request->ajax()) {
            return response()->json(['success' => true, 'message' => 'کد تخفیف به طور کامل حذف شد']);
        }

        return redirect()->route('discounts.trashed')->with('success', 'کد تخفیف به طور کامل حذف شد');
    }
}
