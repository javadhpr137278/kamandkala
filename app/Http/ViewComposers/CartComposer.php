<?php

namespace App\Http\ViewComposers;

use App\Models\Cart;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class CartComposer
{
    /**
     * داده‌های سبد خرید را به ویو ارسال می‌کند
     */
    public function compose(View $view)
    {
        if (Auth::check()) {
            // دریافت آیتم‌های سبد خرید کاربر لاگین شده
            $cartItems = Cart::with(['product', 'color', 'productVariant'])
                ->where('user_id', Auth::id())
                ->get();

            // تعداد کل محصولات در سبد خرید
            $cartCount = $cartItems->sum('quantity');

            // مبلغ کل سبد خرید
            $cartTotal = $cartItems->sum(function($item) {
                return $item->price * $item->quantity;
            });
        } else {
            // کاربر لاگین نیست - سبد خرید خالی
            $cartItems = collect();
            $cartCount = 0;
            $cartTotal = 0;
        }

        // ارسال داده‌ها به ویو
        $view->with([
            'cartItems' => $cartItems,
            'cartCount' => $cartCount,
            'cartTotal' => $cartTotal
        ]);
    }
}
