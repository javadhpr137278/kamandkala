<?php

use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\Home\CategoryProductController;
use App\Http\Controllers\Home\IndexController;
use App\Http\Controllers\Home\PaymentController;
use App\Http\Controllers\ProfileController;
use App\Models\Cart;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Home\ShopController;

// ========== مسیرهای عمومی ==========
Route::get('/', [IndexController::class, 'home'])->name('home');
Route::get('/single-product/{slug}', [IndexController::class, 'singleProduct'])->name('single.product');

// ========== مسیرهای کال‌بک درگاه (بدون middleware auth - مهم) ==========
// استفاده از any به جای get برای دریافت هر دو روش GET و POST
Route::any('/payment/verify', [PaymentController::class, 'verify'])->name('payment.verify');

// ========== مسیرهای نیازمند احراز هویت ==========
Route::middleware(['auth'])->group(function () {

    // ----- مسیرهای سبد خرید -----
    Route::get('/cart', [IndexController::class, 'cart'])->name('user.cart');
    Route::get('/add-to-cart/{product}/{variant?}', [IndexController::class, 'addToCart'])->name('user.add_to_cart');
    Route::delete('/cart/remove/{id}', [IndexController::class, 'removeFromCart'])->name('user.cart.remove');
    Route::put('/cart/update/{id}', [IndexController::class, 'updateCartQuantity'])->name('user.cart.update');

    // ----- مسیرهای مینی کارت -----
    Route::get('/cart/mini', [IndexController::class, 'getMiniCart'])->name('cart.mini');
    Route::delete('/cart/remove-mini/{key}', [IndexController::class, 'removeFromMiniCart'])->name('cart.remove.mini');
    Route::put('/cart/update-mini/{key}', [IndexController::class, 'updateMiniCartQuantity'])->name('cart.update.mini');
    Route::get('/cart/totals', [IndexController::class, 'getCartTotals'])->name('cart.totals');

    // ----- مسیرهای تخفیف و کارت هدیه -----
    Route::post('/cart/apply-discount', [IndexController::class, 'applyDiscount'])->name('cart.apply-discount');
    Route::post('/cart/apply-gift-card', [IndexController::class, 'applyGiftCard'])->name('cart.apply-gift-card');
    Route::delete('/cart/remove-discount', [IndexController::class, 'removeDiscount'])->name('cart.remove-discount');
    Route::delete('/cart/remove-gift-card', [IndexController::class, 'removeGiftCard'])->name('cart.remove-gift-card');

    // ----- مسیرهای تسویه حساب و سفارش -----
    Route::get('/checkout', [IndexController::class, 'checkout'])->name('checkout');
    Route::post('/checkout/store', [IndexController::class, 'storeOrder'])->name('checkout.store'); // اصلاح شد
    Route::get('/order-confirmation/{orderNumber}', [IndexController::class, 'orderConfirmation'])->name('order.confirmation');

    // ----- مسیرهای پرداخت -----
    Route::get('/payment/pay/{order}', [PaymentController::class, 'pay'])->name('payment.pay');
    Route::post('/payment/refund/{payment}', [PaymentController::class, 'refund'])->name('payment.refund');
    Route::get('/payment/{payment}', [PaymentController::class, 'show'])->name('payment.show');
});

Route::get('/category', [CategoryProductController::class, 'index'])->name('home.category.index');
Route::get('/category/{slug}', [CategoryProductController::class, 'show'])->name('home.category.show');
Route::get('/category/{slug}/filter', [CategoryProductController::class, 'filter'])->name('home.category.filter');
Route::get('/category/{slug}/brands', [CategoryProductController::class, 'getBrands'])->name('home.category.brands');

Route::get('/shop', [ShopController::class, 'index'])->name('shop.index');
Route::get('/products/search', [IndexController::class, 'search'])
    ->name('products.search');


// ========== مسیرهای موقت برای ویوهای جزئی ==========
Route::get('/mini-cart', function () {
    if (!Auth::check()) {
        return view('home.partials.mini-cart-empty');
    }

    $cartItems = Cart::with(['product', 'color', 'productVariant'])
        ->where('user_id', Auth::id())
        ->get();

    return view('home.partials.mini-cart-items', compact('cartItems'));
})->name('mini.cart');

// ========== مسیرهای پیش‌فرض لاراول ==========
require __DIR__ . '/auth.php';

Route::get('/dashboard', [DashboardController::class, 'index'])
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/orders/completed', [DashboardController::class, 'completed'])->name('orders.completed');
    Route::get('/user/reviews', [DashboardController::class, 'userReviews'])->name('user.reviews');
    Route::get('/orders/returned', [DashboardController::class, 'returned'])->name('orders.returned');
    Route::get('/orders/{order}', [DashboardController::class, 'show'])->name('dashboard.orders.show');
    Route::get('/orders', [DashboardController::class, 'orders'])->name('dashboard.orders');

    Route::get('/address', [DashboardController::class, 'address'])->name('dashboard.address');
    Route::post('/address/store', [DashboardController::class, 'storeAddress'])->name('dashboard.address.store');
    Route::put('/address/update/{address}', [DashboardController::class, 'updateAddress'])->name('dashboard.address.update');
    Route::delete('/address/delete/{address}', [DashboardController::class, 'deleteAddress'])->name('dashboard.address.delete');
    Route::patch('/address/set-default/{id}', [DashboardController::class, 'setDefaultAddress'])->name('dashboard.address.set-default');

    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});
