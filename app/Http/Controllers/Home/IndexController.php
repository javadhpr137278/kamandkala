<?php

namespace App\Http\Controllers\Home;

use App\Http\Controllers\Controller;
use App\Http\Requests\CheckoutRequest;
use App\Models\BannerAmazing;
use App\Models\Cart;
use App\Models\Category;
use App\Models\Color;
use App\Models\Comment;
use App\Models\Discount;
use App\Models\Gift_card;
use App\Models\Order;
use App\Models\PaymentGateway;
use App\Models\Product;
use App\Models\ProductVariant;
use App\Models\PropertyGroup;
use Hekmatinasser\Verta\Verta;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Session;

class IndexController extends Controller
{
    /**
     * صفحه اصلی
     */
    public function home()
    {
        $banner = BannerAmazing::first();
        $most_sold = Product::with(['category', 'productVariant', 'colors'])
            ->whereHas('productVariant')
            ->orderByDesc('sold')
            ->take(10)
            ->get();
        $latest_products = Product::with(['category', 'productVariant', 'colors'])
            ->whereHas('productVariant')
            ->latest()
            ->take(8)
            ->get();

        $all_products = Product::with(['category', 'productVariant', 'colors'])
            ->take(20)
            ->get();

        $products = Product::with('category')->get();

        return view('home.index', compact('banner', 'most_sold', 'latest_products', 'products', 'all_products'));
    }

    /**
     * صفحه محصولات
     */
    public function shop()
    {
        $products = Product::with(['category', 'productVariant', 'colors'])
            ->whereHas('productVariant')
            ->paginate(12);

        $categories = Category::where('parent_id', 0)->with('children')->get();

        return view('home.shop', compact('products', 'categories'));
    }

    /**
     * صفحه جزئیات محصول
     */
    public function singleProduct($slug)
    {
        $variant = new ProductVariant();

        $product = Cache::remember("product_{$slug}", 3600, function () use ($slug) {
            return Product::query()
                ->with([
                    'category',
                    'brand',
                    'colors',
                    'tags',
                    'properties.propertyGroup',
                    'galleries',
                    'variants.color'
                ])
                ->where('slug', $slug)
                ->firstOrFail();
        });

        $related_products = Cache::remember("related_products_{$product->id}", 3600, function () use ($product) {
            return Product::with(['category', 'productVariant', 'colors'])
                ->where('category_id', $product->category_id)
                ->where('id', '!=', $product->id)
                ->whereHas('productVariant')
                ->inRandomOrder()
                ->take(8)
                ->get();
        });

        $property_groups = PropertyGroup::with('category')->get();

        $categories = Category::query()
            ->where('parent_id', 0)
            ->pluck('title', 'id');

        $comments = $product->comments()
            ->with('user')
            ->orderBy('created_at', 'DESC')
            ->get();

        return view('home.single_product', compact(
            'product',
            'variant',
            'property_groups',
            'categories',
            'related_products',
            'comments',
        ));
    }

    /**
     * نمایش صفحه سبد خرید
     */
    public function cart()
    {
        $cartItems = Cart::with(['product', 'color', 'productVariant'])
            ->where('user_id', Auth::id())
            ->get();

        $subtotal = $cartItems->sum(function ($item) {
            return $item->price * $item->quantity;
        });

        // به‌روزرسانی سشن با مجموع سبد خرید
        Session::put('cart_total', $subtotal);

        // دریافت تخفیف و کارت هدیه از سشن
        $discountAmount = Session::get('discount.amount', 0);
        $giftCardAmount = Session::get('gift_card.balance', 0);

        // محاسبه مبلغ نهایی
        $finalTotal = $subtotal - $discountAmount - $giftCardAmount;
        if ($finalTotal < 0) $finalTotal = 0;

        $total = $finalTotal;

        return view('home.cart', compact('cartItems', 'subtotal', 'discountAmount', 'giftCardAmount', 'finalTotal', 'total'));
    }

    /**
     * افزودن محصول به سبد خرید
     */
    public function addToCart(Request $request, $product, $variant = null)
    {
        if (!Auth::check()) {
            if ($request->ajax()) {
                return response()->json([
                    'success' => false,
                    'message' => 'برای افزودن به سبد خرید ابتدا وارد شوید.',
                    'redirect' => route('login')
                ], 401);
            }
            return redirect()->route('login')->with('error', 'برای افزودن به سبد خرید ابتدا وارد شوید.');
        }

        try {
            $productModel = Product::findOrFail($product);
            $quantity = $request->input('quantity', 1);

            // اگر واریانت ارسال نشده، اولین واریانت را بگیر
            if (!$variant) {
                $firstVariant = ProductVariant::where('product_id', $product)->first();
                if (!$firstVariant) {
                    return back()->with('error', 'هیچ واریانتی برای این محصول یافت نشد.');
                }
                $variant = $firstVariant->id;
            }

            $variantModel = ProductVariant::with('color')->findOrFail($variant);

            if ($variantModel->product_id != $productModel->id) {
                return back()->with('error', 'این واریانت متعلق به محصول انتخاب شده نیست.');
            }

            if ($variantModel->stock < $quantity) {
                return back()->with('error', 'تعداد درخواستی بیشتر از موجودی انبار است.');
            }

            $color = $variantModel->color;
            $price = $variantModel->final_price ?? $variantModel->main_price;

            $existingCart = Cart::where('user_id', Auth::id())
                ->where('product_id', $productModel->id)
                ->where('variant_id', $variantModel->id)
                ->first();

            if ($existingCart) {
                $newQuantity = $existingCart->quantity + $quantity;
                if ($variantModel->stock < $newQuantity) {
                    return back()->with('error', 'تعداد درخواستی بیشتر از موجودی انبار است.');
                }
                $existingCart->quantity = $newQuantity;
                $existingCart->save();
                $message = 'تعداد محصول در سبد خرید بروزرسانی شد.';
            } else {
                Cart::create([
                    'user_id' => Auth::id(),
                    'product_id' => $productModel->id,
                    'variant_id' => $variantModel->id,
                    'color_id' => $color ? $color->id : null,
                    'quantity' => $quantity,
                    'price' => $price
                ]);
                $message = 'محصول با موفقیت به سبد خرید اضافه شد.';
            }

            // به‌روزرسانی سشن
            $this->updateCartTotalSession();

            if ($request->ajax()) {
                return response()->json([
                    'success' => true,
                    'message' => $message,
                    'cart_count' => Cart::where('user_id', Auth::id())->sum('quantity')
                ]);
            }

            return redirect()->route('user.cart')->with('success', $message);

        } catch (\Exception $e) {
            Log::error('Add to Cart Error: ' . $e->getMessage());
            if ($request->ajax()) {
                return response()->json([
                    'success' => false,
                    'message' => 'خطا در افزودن به سبد خرید'
                ], 500);
            }
            return back()->with('error', 'خطا در افزودن به سبد خرید');
        }
    }

    /**
     * بروزرسانی تعداد محصول در سبد خرید
     */
    public function updateCartQuantity(Request $request, $id)
    {
        try {
            $cartItem = Cart::where('user_id', Auth::id())->findOrFail($id);
            $newQuantity = $request->input('quantity', 1);

            $variant = ProductVariant::find($cartItem->variant_id);
            if ($variant && $variant->stock < $newQuantity) {
                return response()->json([
                    'success' => false,
                    'message' => 'تعداد درخواستی بیشتر از موجودی انبار است.'
                ], 400);
            }

            $cartItem->quantity = $newQuantity;
            $cartItem->save();

            // به‌روزرسانی سشن
            $this->updateCartTotalSession();

            // اگر تخفیف وجود دارد، دوباره محاسبه کن
            if (Session::has('discount')) {
                $this->recalculateDiscount();
            }

            return response()->json([
                'success' => true,
                'cart' => $this->getCartData()
            ]);

        } catch (\Exception $e) {
            Log::error('Update Cart Quantity Error: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'خطا در بروزرسانی سبد خرید'
            ], 500);
        }
    }

    /**
     * حذف محصول از سبد خرید
     */
    public function removeFromCart($id)
    {
        try {
            $cartItem = Cart::where('user_id', Auth::id())->findOrFail($id);
            $cartItem->delete();

            // به‌روزرسانی سشن
            $this->updateCartTotalSession();

            // اگر سبد خرید خالی شد، تخفیف و کارت هدیه را پاک کن
            if (Cart::where('user_id', Auth::id())->count() === 0) {
                Session::forget('discount');
                Session::forget('gift_card');
            } else {
                // اگر تخفیف وجود دارد، دوباره محاسبه کن
                if (Session::has('discount')) {
                    $this->recalculateDiscount();
                }
            }

            if (request()->ajax()) {
                return response()->json([
                    'success' => true,
                    'cart' => $this->getCartData()
                ]);
            }

            return back()->with('success', 'محصول از سبد خرید حذف شد.');

        } catch (\Exception $e) {
            Log::error('Remove from Cart Error: ' . $e->getMessage());
            if (request()->ajax()) {
                return response()->json([
                    'success' => false,
                    'message' => 'خطا در حذف محصول'
                ], 500);
            }
            return back()->with('error', 'خطا در حذف محصول');
        }
    }

    /**
     * دریافت مینی سبد خرید
     */
    public function getMiniCart()
    {
        if (!Auth::check()) {
            return response()->json(['html' => view('home.partials.mini-cart-empty')->render()]);
        }

        $cartItems = Cart::with(['product', 'color', 'productVariant'])
            ->where('user_id', Auth::id())
            ->get();

        $html = view('home.partials.mini-cart-items', compact('cartItems'))->render();

        return response()->json(['html' => $html]);
    }

    /**
     * حذف از مینی سبد خرید
     */
    public function removeFromMiniCart($key)
    {
        try {
            $cartItem = Cart::where('user_id', Auth::id())->findOrFail($key);
            $cartItem->delete();

            // به‌روزرسانی سشن
            $this->updateCartTotalSession();

            if (Cart::where('user_id', Auth::id())->count() === 0) {
                Session::forget('discount');
                Session::forget('gift_card');
            } else {
                if (Session::has('discount')) {
                    $this->recalculateDiscount();
                }
            }

            $cartItems = Cart::with(['product', 'color', 'productVariant'])
                ->where('user_id', Auth::id())
                ->get();

            $count = $cartItems->sum('quantity');
            $total = $cartItems->sum(function ($item) {
                return $item->price * $item->quantity;
            });

            $html = view('home.partials.mini-cart-items', compact('cartItems'))->render();

            return response()->json([
                'success' => true,
                'html' => $html,
                'count' => $count,
                'total' => number_format($total)
            ]);

        } catch (\Exception $e) {
            Log::error('Remove from Mini Cart Error: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'خطا در حذف محصول'
            ], 500);
        }
    }

    /**
     * بروزرسانی تعداد در مینی سبد خرید
     */
    public function updateMiniCartQuantity(Request $request, $key)
    {
        try {
            $cartItem = Cart::where('user_id', Auth::id())->findOrFail($key);
            $newQuantity = $request->input('quantity', 1);

            $variant = ProductVariant::find($cartItem->variant_id);
            if ($variant && $variant->stock < $newQuantity) {
                return response()->json([
                    'success' => false,
                    'message' => 'تعداد درخواستی بیشتر از موجودی انبار است.'
                ], 400);
            }

            $cartItem->quantity = $newQuantity;
            $cartItem->save();

            $this->updateCartTotalSession();

            if (Session::has('discount')) {
                $this->recalculateDiscount();
            }

            $cartItems = Cart::with(['product', 'color', 'productVariant'])
                ->where('user_id', Auth::id())
                ->get();

            $count = $cartItems->sum('quantity');
            $total = $cartItems->sum(function ($item) {
                return $item->price * $item->quantity;
            });

            $html = view('home.partials.mini-cart-items', compact('cartItems'))->render();

            return response()->json([
                'success' => true,
                'html' => $html,
                'count' => $count,
                'total' => number_format($total)
            ]);

        } catch (\Exception $e) {
            Log::error('Update Mini Cart Quantity Error: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'خطا در بروزرسانی'
            ], 500);
        }
    }

    /**
     * دریافت مجموع سبد خرید
     */
    public function getCartTotals()
    {
        if (!Auth::check()) {
            return response()->json(['count' => 0, 'total' => 0]);
        }

        $cartItems = Cart::where('user_id', Auth::id())->get();
        $count = $cartItems->sum('quantity');
        $total = $cartItems->sum(function ($item) {
            return $item->price * $item->quantity;
        });

        return response()->json([
            'count' => $count,
            'total' => number_format($total)
        ]);
    }

    /**
     * اعمال کد تخفیف
     */
    /**
     * اعمال کد تخفیف
     */
    public function applyDiscount(Request $request)
    {
        try {
            Log::info('=== Apply Discount Request Started ===');
            Log::info('Request data:', $request->all());

            $request->validate([
                'code' => 'required|string'
            ]);

            $code = $request->code;
            Log::info('Looking for discount code: ' . $code);

            $discount = Discount::where('code', $code)->first();

            if (!$discount) {
                Log::warning('Discount code not found: ' . $code);
                return response()->json([
                    'success' => false,
                    'message' => 'کد تخفیف یافت نشد'
                ], 404);
            }

            Log::info('Discount found:', ['id' => $discount->id, 'type' => $discount->type, 'value' => $discount->value]);

            // بررسی اعتبار کد تخفیف
            $now = now();
            if ($discount->expires_at && $discount->expires_at < $now) {
                Log::warning('Discount code expired: ' . $code);
                return response()->json([
                    'success' => false,
                    'message' => 'این کد تخفیف منقضی شده است'
                ], 400);
            }

            Log::info('Discount code is valid');

            // دریافت مجموع سبد خرید
            $cartTotal = $this->getCartTotalFromDB();
            Log::info('Cart total: ' . $cartTotal);

            // بررسی حداقل مبلغ سفارش
            if ($discount->minimum_order_amount && $cartTotal < $discount->minimum_order_amount) {
                Log::warning('Minimum order amount not met. Required: ' . $discount->minimum_order_amount . ', Current: ' . $cartTotal);
                return response()->json([
                    'success' => false,
                    'message' => "حداقل مبلغ سفارش برای استفاده از این کد تخفیف " . number_format($discount->minimum_order_amount) . " تومان می‌باشد"
                ], 400);
            }

            // محاسبه مبلغ تخفیف
            $discountAmount = 0;
            if ($discount->type === 'fixed') {
                $discountAmount = min($discount->value, $cartTotal);
                Log::info('Fixed discount calculated: ' . $discountAmount);
            } else {
                // درصدی
                $discountAmount = ($cartTotal * $discount->value) / 100;
                Log::info('Percentage discount calculated (raw): ' . $discountAmount);
                if ($discount->max_discount_amount && $discountAmount > $discount->max_discount_amount) {
                    $discountAmount = $discount->max_discount_amount;
                    Log::info('Max discount applied: ' . $discountAmount);
                }
            }

            if ($discountAmount <= 0) {
                Log::warning('Discount amount is zero or negative: ' . $discountAmount);
                return response()->json([
                    'success' => false,
                    'message' => 'این کد تخفیف برای سبد خرید شما قابل استفاده نیست'
                ], 400);
            }

            // ذخیره در سشن
            Session::put('discount', [
                'id' => $discount->id,
                'code' => $discount->code,
                'type' => $discount->type,
                'value' => $discount->value,
                'amount' => $discountAmount,
                'max_discount' => $discount->max_discount_amount,
                'minimum_order_amount' => $discount->minimum_order_amount
            ]);

            Log::info('Discount saved to session:', Session::get('discount'));

            $cartData = $this->getCartData();
            Log::info('Returning cart data:', $cartData);

            return response()->json([
                'success' => true,
                'message' => 'کد تخفیف با موفقیت اعمال شد',
                'discount_amount' => $discountAmount,
                'cart' => $cartData
            ]);

        } catch (\Exception $e) {
            Log::error('Apply Discount Error: ' . $e->getMessage());
            Log::error('Apply Discount Trace: ' . $e->getTraceAsString());
            return response()->json([
                'success' => false,
                'message' => 'خطا در اعمال کد تخفیف: ' . $e->getMessage()
            ], 500);
        }
    }
    /**
     * حذف کد تخفیف
     */
    public function removeDiscount()
    {
        try {
            Session::forget('discount');

            return response()->json([
                'success' => true,
                'message' => 'کد تخفیف با موفقیت حذف شد',
                'cart' => $this->getCartData()
            ]);
        } catch (\Exception $e) {
            Log::error('Remove Discount Error: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'خطا در حذف کد تخفیف'
            ], 500);
        }
    }

    /**
     * اعمال کارت هدیه
     */
    public function applyGiftCard(Request $request)
    {
        try {
            $request->validate([
                'code' => 'required|string'
            ]);

            $giftCard = Gift_card::where('code', $request->code)->first();

            if (!$giftCard) {
                return response()->json([
                    'success' => false,
                    'message' => 'کارت هدیه یافت نشد'
                ], 404);
            }

            if (!$giftCard->isValid()) {
                return response()->json([
                    'success' => false,
                    'message' => 'این کارت هدیه معتبر نمی‌باشد'
                ], 400);
            }

            Session::put('gift_card', [
                'id' => $giftCard->id,
                'code' => $giftCard->code,
                'balance' => $giftCard->current_balance,
            ]);

            return response()->json([
                'success' => true,
                'message' => 'کارت هدیه با موفقیت اعمال شد',
                'gift_card_balance' => $giftCard->current_balance,
                'cart' => $this->getCartData()
            ]);

        } catch (\Exception $e) {
            Log::error('Apply Gift Card Error: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'خطا در اعمال کارت هدیه'
            ], 500);
        }
    }

    /**
     * حذف کارت هدیه
     */
    public function removeGiftCard()
    {
        try {
            Session::forget('gift_card');

            return response()->json([
                'success' => true,
                'message' => 'کارت هدیه با موفقیت حذف شد',
                'cart' => $this->getCartData()
            ]);
        } catch (\Exception $e) {
            Log::error('Remove Gift Card Error: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'خطا در حذف کارت هدیه'
            ], 500);
        }
    }

    /**
     * بازمحاسبه تخفیف بعد از تغییر سبد خرید
     */
    private function recalculateDiscount()
    {
        $discountData = Session::get('discount');
        if (!$discountData) return;

        $discount = Discount::find($discountData['id']);
        if (!$discount) {
            Session::forget('discount');
            return;
        }

        $cartTotal = $this->getCartTotalFromDB();

        // بررسی حداقل مبلغ سفارش
        if ($discount->minimum_order_amount && $cartTotal < $discount->minimum_order_amount) {
            Session::forget('discount');
            return;
        }

        // محاسبه مجدد مبلغ تخفیف
        $discountAmount = 0;
        if ($discount->type === 'fixed') {
            $discountAmount = min($discount->value, $cartTotal);
        } else {
            $discountAmount = ($cartTotal * $discount->value) / 100;
            if ($discount->max_discount_amount && $discountAmount > $discount->max_discount_amount) {
                $discountAmount = $discount->max_discount_amount;
            }
        }

        if ($discountAmount <= 0) {
            Session::forget('discount');
        } else {
            Session::put('discount.amount', $discountAmount);
        }
    }

    /**
     * دریافت اطلاعات کامل سبد خرید
     */
    private function getCartData()
    {
        $subtotal = $this->getCartTotalFromDB();
        $discountAmount = Session::get('discount.amount', 0);
        $giftCardBalance = Session::get('gift_card.balance', 0);

        // محاسبه مبلغ قابل استفاده از کارت هدیه
        $remainingAfterDiscount = $subtotal - $discountAmount;
        $giftCardAmount = min($giftCardBalance, max($remainingAfterDiscount, 0));

        return [
            'subtotal' => $subtotal,
            'discount_amount' => $discountAmount,
            'discount_code' => Session::get('discount.code'),
            'gift_card_amount' => $giftCardAmount,
            'gift_card_code' => Session::get('gift_card.code'),
            'total' => max(0, $subtotal - $discountAmount - $giftCardAmount),
            'items_count' => Cart::where('user_id', Auth::id())->sum('quantity')
        ];
    }

    /**
     * محاسبه مجموع سبد خرید از دیتابیس
     */
    private function getCartTotalFromDB()
    {
        $cartItems = Cart::where('user_id', Auth::id())->get();

        $total = $cartItems->sum(function ($item) {
            return $item->price * $item->quantity;
        });

        return $total;
    }

    /**
     * به‌روزرسانی سشن با مجموع سبد خرید
     */
    private function updateCartTotalSession()
    {
        $total = $this->getCartTotalFromDB();
        Session::put('cart_total', $total);
        return $total;
    }

    /**
     * صفحه تسویه حساب
     */
    public function checkout()
    {
        $payment_gateways = PaymentGateway::where('is_active', 1)->get();

        $cartItems = Cart::with(['product', 'color', 'productVariant'])
            ->where('user_id', Auth::id())
            ->get();

        if ($cartItems->isEmpty()) {
            return redirect()->route('user.cart')->with('error', 'سبد خرید شما خالی است.');
        }

        $subtotal = $this->getCartTotalFromDB();
        $discountAmount = Session::get('discount.amount', 0);
        $giftCardAmount = Session::get('gift_card.balance', 0);

        $shippingCost = 50000;
        $total = $subtotal - $discountAmount - $giftCardAmount + $shippingCost;
        if ($total < 0) $total = 0;

        $shippingDates = $this->getShippingDates();

        $user = Auth::user();
        $userData = [
            'billing_first_name' => $user->name ?? '',
            'billing_last_name' => $user->family ?? '',
            'billing_phone' => $user->mobile ?? '',
            'billing_email' => $user->email ?? '',
        ];

        return view('home.checkout', compact(
            'cartItems',
            'subtotal',
            'discountAmount',
            'giftCardAmount',
            'shippingCost',
            'total',
            'shippingDates',
            'userData',
            'payment_gateways'
        ));
    }

    /**
     * ثبت سفارش
     */
    public function storeOrder(CheckoutRequest $request)
    {
        try {
            DB::beginTransaction();

            $cartItems = Cart::with(['product', 'color', 'productVariant'])
                ->where('user_id', Auth::id())
                ->get();

            if ($cartItems->isEmpty()) {
                return redirect()->route('user.cart')->with('error', 'سبد خرید شما خالی است.');
            }

            // محاسبه قیمت‌ها
            $subtotal = 0;
            $orderItemsArray = [];

            foreach ($cartItems as $item) {
                $itemPrice = $item->price;
                $itemTotal = $itemPrice * $item->quantity;
                $subtotal += $itemTotal;

                $orderItemsArray[] = [
                    'cart_id' => $item->id,
                    'product_id' => $item->product_id,
                    'product_name' => $item->product->title ?? 'محصول',
                    'product_slug' => $item->product->slug ?? '',
                    'variant_id' => $item->variant_id,
                    'variant_title' => $item->productVariant->title ?? '',
                    'color_id' => $item->color_id,
                    'color_name' => $item->color->name ?? '',
                    'color_code' => $item->color->code ?? '',
                    'quantity' => $item->quantity,
                    'unit_price' => $itemPrice,
                    'total_price' => $itemTotal,
                ];
            }

            // اعمال تخفیف و کارت هدیه
            $discountAmount = Session::get('discount.amount', 0);
            $giftCardData = Session::get('gift_card');
            $giftCardAmount = $giftCardData['balance'] ?? 0;

            $shippingCost = 50000;
            $total = $subtotal - $discountAmount - $giftCardAmount + $shippingCost;
            if ($total < 0) $total = 0;

            $shippingDate = $this->convertPersianToGregorian($request->recive_date_shipping);
            $paymentMethod = $this->normalizePaymentMethod($request->payment_method);

            $orderData = [
                'order_number' => $this->generateOrderNumber(),
                'user_id' => Auth::id(),
                'billing_first_name' => $request->billing_first_name,
                'billing_last_name' => $request->billing_last_name,
                'billing_phone' => $request->billing_phone,
                'billing_email' => $request->billing_email,
                'address_choice' => $request->address_choice,
                'shipping_date' => $shippingDate,
                'shipping_date_persian' => $request->recive_date_shipping,
                'order_items' => json_encode($orderItemsArray, JSON_UNESCAPED_UNICODE),
                'subtotal' => $subtotal,
                'discount_amount' => $discountAmount,
                'gift_card_amount' => $giftCardAmount,
                'shipping_cost' => $shippingCost,
                'total' => $total,
                'payment_method' => $paymentMethod,
                'status' => 'pending',
                'notes' => $request->notes ?? null,
            ];

            // اضافه کردن آدرس
            switch ($request->address_choice) {
                case 'billing':
                    $orderData['billing_address_1'] = $request->billing_address_1;
                    $orderData['billing_address_2'] = $request->billing_address_2 ?? null;
                    $orderData['billing_city'] = $request->billing_city;
                    $orderData['billing_state'] = $request->billing_state;
                    $orderData['billing_postcode'] = $request->billing_postcode;
                    break;
                case 'shipping':
                    $orderData['shipping_first_name'] = $request->shipping_first_name ?? $request->billing_first_name;
                    $orderData['shipping_last_name'] = $request->shipping_last_name ?? $request->billing_last_name;
                    $orderData['shipping_phone'] = $request->shipping_phone ?? $request->billing_phone;
                    $orderData['shipping_address_1'] = $request->shipping_address_1;
                    $orderData['shipping_address_2'] = $request->shipping_address_2 ?? null;
                    $orderData['shipping_city'] = $request->shipping_city;
                    $orderData['shipping_state'] = $request->shipping_state;
                    $orderData['shipping_postcode'] = $request->shipping_postcode;
                    break;
                case 'custom':
                    $orderData['custom_address'] = $request->new_address;
                    $orderData['custom_city'] = $request->new_city;
                    $orderData['custom_postcode'] = $request->new_postcode;
                    break;
            }

            $order = Order::create($orderData);

            // کاهش موجودی
            foreach ($cartItems as $item) {
                $variant = ProductVariant::find($item->variant_id);
                if ($variant) {
                    $variant->decrement('stock', $item->quantity);
                    $variant->product->increment('sold', $item->quantity);
                }
            }

            // اگر کارت هدیه استفاده شده، موجودی آن را کاهش بده
            if (isset($giftCardData) && $giftCardAmount > 0) {
                $giftCard = Gift_card::find($giftCardData['id']);
                if ($giftCard) {
                    $giftCard->decrement('current_balance', $giftCardAmount);
                }
            }

            // حذف سبد خرید و تخفیف‌ها
            Cart::where('user_id', Auth::id())->delete();
            Session::forget('discount');
            Session::forget('gift_card');
            Session::forget('cart_total');

            DB::commit();

            Log::info('Order created successfully', [
                'order_id' => $order->id,
                'order_number' => $order->order_number
            ]);

            return redirect()->route('payment.pay', $order);

        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Order Store Error: ' . $e->getMessage());
            Log::error('Order Store Trace: ' . $e->getTraceAsString());

            return redirect()->back()
                ->withInput()
                ->with('error', 'خطا در ثبت سفارش: ' . $e->getMessage());
        }
    }

    /**
     * تایید سفارش
     */
    public function orderConfirmation($orderNumber)
    {
        $order = Order::where('order_number', $orderNumber)
            ->where('user_id', Auth::id())
            ->firstOrFail();

        $orderItems = json_decode($order->order_items, true);
        $totalFormatted = number_format($order->total);

        $payment = \App\Models\Payment::where('order_id', $order->id)
            ->where('status', 'completed')
            ->latest()
            ->first();

        $paymentStatus = '';
        switch ($order->payment_method) {
            case 'zibal':
                $paymentStatus = 'زرین‌پال (زیبال)';
                break;
            case 'cod':
                $paymentStatus = 'پرداخت در محل';
                break;
            case 'bacs':
                $paymentStatus = 'انتقال بانکی';
                break;
            default:
                $paymentStatus = 'پرداخت آنلاین';
        }

        $orderStatus = '';
        switch ($order->status) {
            case 'pending':
                $orderStatus = 'در انتظار پرداخت';
                break;
            case 'processing':
                $orderStatus = 'در حال پردازش';
                break;
            case 'completed':
                $orderStatus = 'تکمیل شده';
                break;
            case 'cancelled':
                $orderStatus = 'لغو شده';
                break;
            case 'failed':
                $orderStatus = 'ناموفق';
                break;
            default:
                $orderStatus = $order->status;
        }

        $persianDate = $order->shipping_date_persian ?? $this->convertGregorianToPersian($order->created_at);

        return view('home.payment.success', compact(
            'order',
            'orderItems',
            'totalFormatted',
            'paymentStatus',
            'orderStatus',
            'persianDate',
            'payment'
        ));
    }

    /**
     * جستجوی محصولات
     */
    public function search(Request $request)
    {
        $query = $request->input('s');

        $products = Product::query()
            ->where('title', 'LIKE', "%{$query}%")
            ->orWhere('description', 'LIKE', "%{$query}%")
            ->orWhere('name', 'LIKE', "%{$query}%")
            ->paginate(12);

        return view('home.search', compact('products', 'query'));
    }

    // ========== توابع کمکی ==========

    private function normalizePaymentMethod($method)
    {
        $mapping = [
            'زرین‌پال' => 'zarinpal',
            'زرین پال' => 'zarinpal',
            'zarinpal' => 'zarinpal',
            'آیدی پی' => 'idpay',
            'idpay' => 'idpay',
            'زیبال' => 'zibal',
            'zibal' => 'zibal',
            'پی' => 'payir',
            'pay.ir' => 'payir',
            'payir' => 'payir',
            'نکست پی' => 'nextpay',
            'nextpay' => 'nextpay',
            'سامان' => 'saman',
            'saman' => 'saman',
            'پرداخت در محل' => 'cod',
            'cod' => 'cod',
            'انتقال بانکی' => 'bacs',
            'bacs' => 'bacs',
        ];

        return $mapping[$method] ?? 'pending';
    }

    private function generateOrderNumber(): string
    {
        $prefix = 'KM';
        $date = Verta::now()->format('Ymd');

        $lastOrder = Order::whereDate('created_at', today())
            ->orderBy('id', 'desc')
            ->first();

        if ($lastOrder) {
            $parts = explode('-', $lastOrder->order_number);
            $lastNumber = intval(end($parts));
            $newNumber = str_pad($lastNumber + 1, 3, '0', STR_PAD_LEFT);
        } else {
            $newNumber = '001';
        }

        return "{$prefix}-{$date}-{$newNumber}";
    }

    private function getShippingDates(): array
    {
        try {
            $dates = [];
            $startDate = Verta::now()->addDays(3);

            for ($i = 0; $i < 6; $i++) {
                $date = $startDate->copy()->addDays($i);
                $dates[] = [
                    'value' => $date->format('Y/m/d'),
                    'label' => $date->format('l d F'),
                    'year' => $date->format('Y'),
                ];
            }

            return $dates;
        } catch (\Exception $e) {
            return [
                ['value' => '۱۴۰۴/۱۲/۲۹', 'label' => 'جمعه ۲۹ اسفند', 'year' => '۱۴۰۴'],
                ['value' => '۱۴۰۵/۰۱/۰۱', 'label' => 'شنبه ۰۱ فروردین', 'year' => '۱۴۰۵'],
                ['value' => '۱۴۰۵/۰۱/۰۲', 'label' => 'یکشنبه ۰۲ فروردین', 'year' => '۱۴۰۵'],
                ['value' => '۱۴۰۵/۰۱/۰۳', 'label' => 'دوشنبه ۰۳ فروردین', 'year' => '۱۴۰۵'],
                ['value' => '۱۴۰۵/۰۱/۰۴', 'label' => 'سه شنبه ۰۴ فروردین', 'year' => '۱۴۰۵'],
                ['value' => '۱۴۰۵/۰۱/۰۵', 'label' => 'چهارشنبه ۰۵ فروردین', 'year' => '۱۴۰۵'],
            ];
        }
    }

    private function convertPersianToGregorian($persianDate): string
    {
        try {
            $cleanDate = $this->persianToEnglishNumbers($persianDate);
            $verta = Verta::parse($cleanDate);
            return $verta->datetime()->format('Y-m-d');
        } catch (\Exception $e) {
            Log::warning('خطا در تبدیل تاریخ شمسی به میلادی: ' . $e->getMessage());
            return now()->toDateString();
        }
    }

    private function convertGregorianToPersian($date)
    {
        try {
            if ($date instanceof \DateTime) {
                return Verta::instance($date)->format('d F Y');
            }
            if (is_string($date)) {
                return Verta::parse($date)->format('d F Y');
            }
            return Verta::now()->format('d F Y');
        } catch (\Exception $e) {
            return now()->format('Y/m/d');
        }
    }

    private function persianToEnglishNumbers($string)
    {
        $persian = ['۰', '۱', '۲', '۳', '۴', '۵', '۶', '۷', '۸', '۹'];
        $english = ['0', '1', '2', '3', '4', '5', '6', '7', '8', '9'];

        return str_replace($persian, $english, $string);
    }
}
