<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Gift_card;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class GiftCardController extends Controller
{
    public function index()
    {
        $giftCards = Gift_card::with('user', 'transactions')->orderBy('id', 'desc')->paginate(20);
        return view('admin.gift-cards.list', compact('giftCards'));
    }

    public function create()
    {
        $users = User::all();
        return view('admin.gift-cards.create', compact('users'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'initial_balance' => 'required|numeric|min:1000',
            'user_id' => 'nullable|exists:users,id',
            'expires_at' => 'nullable|date',
            'is_active' => 'boolean',
        ]);

        $validated['code'] = 'GC-' . strtoupper(Str::random(12));
        $validated['current_balance'] = $validated['initial_balance'];
        $validated['is_active'] = $request->has('is_active');

        Gift_card::create($validated);

        return redirect()->route('gift-cards.index')->with('success', 'کارت هدیه با موفقیت ایجاد شد');
    }

    public function show(Gift_card $giftCard)
    {
        $giftCard->load('user', 'transactions.order');
        return view('admin.gift-cards.show', compact('giftCard'));
    }

    public function destroy(Gift_card $giftCard, Request $request)
    {
        $giftCard->delete();

        if ($request->ajax()) {
            return response()->json(['success' => true, 'message' => 'کارت هدیه با موفقیت حذف شد']);
        }

        return redirect()->route('gift-cards.index')->with('success', 'کارت هدیه حذف شد');
    }

    public function toggleStatus(Gift_card $giftCard, Request $request)
    {
        $giftCard->is_active = !$giftCard->is_active;
        $giftCard->save();

        if ($request->ajax()) {
            return response()->json([
                'success' => true,
                'message' => 'وضعیت کارت هدیه با موفقیت تغییر کرد',
                'new_status' => $giftCard->is_active
            ]);
        }

        return back()->with('success', 'وضعیت کارت هدیه تغییر کرد');
    }

    public function trashed()
    {
        $trashedGiftCards = Gift_card::onlyTrashed()->paginate(20);
        return view('admin.gift-cards.trashed', compact('trashedGiftCards'));
    }

    public function restore($id, Request $request)
    {
        $giftCard = Gift_card::onlyTrashed()->findOrFail($id);
        $giftCard->restore();

        if ($request->ajax()) {
            return response()->json(['success' => true, 'message' => 'کارت هدیه با موفقیت بازیابی شد']);
        }

        return redirect()->route('gift-cards.index')->with('success', 'کارت هدیه بازیابی شد');
    }

    public function forceDelete($id, Request $request)
    {
        $giftCard = Gift_card::onlyTrashed()->findOrFail($id);
        $giftCard->forceDelete();

        if ($request->ajax()) {
            return response()->json(['success' => true, 'message' => 'کارت هدیه به طور کامل حذف شد']);
        }

        return redirect()->route('gift-cards.trashed')->with('success', 'کارت هدیه به طور کامل حذف شد');
    }
}

