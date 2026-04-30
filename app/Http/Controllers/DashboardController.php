<?php

namespace App\Http\Controllers;

use App\Models\Address;
use App\Models\Comment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Order;
use Illuminate\Support\Facades\Log;

class DashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        // بررسی وجود کاربر
        if (!$user) {
            return redirect()->route('login');
        }

        // آمارها
        $completedOrders = Order::where('user_id', $user->id)
            ->where('status', 'completed')->count();

        $userReviews = Comment::where('user_id', $user->id)->count();
        $returnedOrders = Order::where('user_id', $user->id)
            ->where('status', 'returned')->count();

        // دریافت 5 سفارش اخیر
        $latestOrders = Order::where('user_id', $user->id)
            ->orderBy('created_at', 'desc')
            ->limit(5)
            ->get();

        Log::info('User ID: ' . $user->id);
        Log::info('Latest Orders Count: ' . $latestOrders->count());

        return view('dashboard', compact(
            'user',
            'completedOrders',
            'userReviews',
            'returnedOrders',
            'latestOrders'
        ));
    }

    public function orders()
    {
        $user = Auth::user();

        if (!$user) {
            return redirect()->route('login');
        }

        $latestOrders = Order::where('user_id', $user->id)
            ->orderBy('created_at', 'desc')
            ->paginate(6);

        return view('profile.orders', compact('latestOrders'));
    }

    public function address()
    {
        $user = Auth::user();

        // فقط از جدول addresses بگیر
        $addresses = Address::where('user_id', $user->id)
            ->orderBy('is_default', 'desc')
            ->orderBy('created_at', 'desc')
            ->get();

        return view('profile.address', compact('addresses'));
    }

    // ذخیره آدرس جدید
    public function storeAddress(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'recipient_name' => 'required|string|max:255',
            'recipient_phone' => 'required|string|max:20',
            'address' => 'required|string',
            'city' => 'required|string|max:255',
            'postcode' => 'nullable|string|max:20',
            'plaque' => 'nullable|string|max:50',
            'unit' => 'nullable|string|max:50',
        ]);

        // اگر این اولین آدرس است، به عنوان پیش‌فرض ذخیره شود
        $isFirstAddress = Address::where('user_id', Auth::id())->count() == 0;

        $address = Address::create([
            'user_id' => Auth::id(),
            'title' => $request->title,
            'type' => 'custom',
            'recipient_name' => $request->recipient_name,
            'recipient_phone' => $request->recipient_phone,
            'address' => $request->address,
            'city' => $request->city,
            'state' => $request->state,
            'postcode' => $request->postcode,
            'plaque' => $request->plaque,
            'unit' => $request->unit,
            'is_default' => $request->has('is_default') || $isFirstAddress,
        ]);

        if ($request->has('is_default') && !$isFirstAddress) {
            $this->setDefaultAddress($address->id);
        }

        return redirect()->route('dashboard.address')->with('success', 'آدرس با موفقیت اضافه شد');
    }

    // ویرایش آدرس
    public function updateAddress(Request $request, $id)
    {
        $address = Address::findOrFail($id);

        if ($address->user_id !== Auth::id()) {
            abort(403);
        }

        $request->validate([
            'title' => 'required|string|max:255',
            'recipient_name' => 'required|string|max:255',
            'recipient_phone' => 'required|string|max:20',
            'address' => 'required|string',
            'city' => 'required|string|max:255',
            'postcode' => 'nullable|string|max:20',
            'plaque' => 'nullable|string|max:50',
            'unit' => 'nullable|string|max:50',
        ]);

        $address->update([
            'title' => $request->title,
            'recipient_name' => $request->recipient_name,
            'recipient_phone' => $request->recipient_phone,
            'address' => $request->address,
            'city' => $request->city,
            'state' => $request->state,
            'postcode' => $request->postcode,
            'plaque' => $request->plaque,
            'unit' => $request->unit,
        ]);

        if ($request->has('is_default')) {
            $this->setDefaultAddress($address->id);
        }

        return redirect()->route('dashboard.address')->with('success', 'آدرس با موفقیت ویرایش شد');
    }

    // حذف آدرس
    public function deleteAddress($id)
    {
        $address = Address::findOrFail($id);

        if ($address->user_id !== Auth::id()) {
            abort(403);
        }

        $wasDefault = $address->is_default;
        $address->delete();

        if ($wasDefault) {
            $newDefault = Address::where('user_id', Auth::id())->first();
            if ($newDefault) {
                $newDefault->update(['is_default' => true]);
            }
        }

        return redirect()->route('dashboard.address')->with('success', 'آدرس با موفقیت حذف شد');
    }

    // تنظیم آدرس پیش‌فرض
    public function setDefaultAddress($id)
    {
        // حذف آدرس پیش‌فرض قبلی
        Address::where('user_id', Auth::id())->update(['is_default' => false]);

        // تنظیم آدرس جدید به عنوان پیش‌فرض
        $address = Address::findOrFail($id);
        $address->update(['is_default' => true]);

        return redirect()->route('dashboard.address')->with('success', 'آدرس پیش‌فرض با موفقیت تغییر کرد');
    }

    public function show($order)
    {
        $user = Auth::user();

        // بررسی وجود کاربر
        if (!$user) {
            return redirect()->route('login');
        }

        // دریافت سفارش با بررسی مالکیت
        $order = Order::where('user_id', $user->id)
            ->where('id', $order)
            ->firstOrFail();

        // تبدیل order_items به آرایه
        $orderItems = is_array($order->order_items)
            ? $order->order_items
            : json_decode($order->order_items, true);

        return view('profile.order-items', compact('order', 'orderItems'));
    }
}
