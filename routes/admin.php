<?php

use App\Http\Controllers\Admin\BannerAmazingController;
use App\Http\Controllers\Admin\BrandController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\ColorController;
use App\Http\Controllers\Admin\CommentController;
use App\Http\Controllers\Admin\DiscountController;
use App\Http\Controllers\Admin\GiftCardController;
use App\Http\Controllers\Admin\GuarantyController;
use App\Http\Controllers\Admin\PanelController;
use App\Http\Controllers\Admin\PaymentController;
use App\Http\Controllers\Admin\ProductController;
use App\Http\Controllers\Admin\ProductVariantController;
use App\Http\Controllers\Admin\PropertyGroupController;
use App\Http\Controllers\Admin\RoleController;
use App\Http\Controllers\Admin\TagController;
use App\Http\Controllers\Admin\UserController;
use Illuminate\Support\Facades\Route;

// --- Main Route --- //
Route::get('/', [PanelController::class, 'index'])->name('panel');

// -- Users Route -- //
Route::resource('users', UserController::class);
Route::resource('roles', RoleController::class);
Route::get('create_user_role/{id}', [UserController::class, 'createUserRole'])->name('create.user.role');
Route::post('store_user_role/{id}', [UserController::class, 'storeUserRole'])->name('store.user.role');

// -- Shopping Route -- //
Route::resource('categories', CategoryController::class);

// --- Brands --- //
Route::resource('brands', BrandController::class);
Route::get('trashed-brand', [BrandController::class, 'trashed'])->name('brands.trashed');
Route::delete('brands/{id}/force-delete', [BrandController::class, 'forceDelete'])->name('brands.forceDelete');
Route::post('brands/{id}/restore', [BrandController::class, 'restore'])->name('brands.restore');

// --- Colors --- //
Route::resource('colors', ColorController::class);
Route::get('trashed-color', [ColorController::class, 'trashed'])->name('colors.trashed');
Route::delete('colors/{id}/force-delete', [ColorController::class, 'forceDelete'])->name('colors.forceDelete');
Route::post('colors/{id}/restore', [ColorController::class, 'restore'])->name('colors.restore');

// --- Tags --- //
Route::resource('tags', TagController::class);
Route::get('trashed-tag', [TagController::class, 'trashed'])->name('tags.trashed');
Route::delete('tags/{id}/force-delete', [TagController::class, 'forceDelete'])->name('tags.forceDelete');
Route::post('tags/{id}/restore', [TagController::class, 'restore'])->name('tags.restore');

// --- Products --- //
Route::resource('products', ProductController::class);

Route::get('products/{product}/properties/create', [ProductController::class, 'CreateProductProperty'])->name('create.product.properties');
Route::post('products/{product}/properties/store', [ProductController::class, 'StoreProductProperty'])->name('store.product.properties');
Route::get('products/{product}/properties/edit', [ProductController::class, 'EditProperty'])->name('property.edit');
Route::post('products/{product}/properties/update', [ProductController::class, 'UpdateProperty'])->name('property.update');
Route::delete('products/{product}/properties/delete', [ProductController::class, 'DestroyProperty'])->name('property.destroy');

Route::get('trashed-product', [ProductController::class, 'trashed'])->name('products.trashed');
Route::delete('products/{id}/force-delete', [ProductController::class, 'forceDelete'])->name('products.forceDelete');
Route::post('products/{id}/restore', [ProductController::class, 'restore'])->name('products.restore');

// --- Guaranty --- //
Route::resource('guaranties', GuarantyController::class);
Route::get('trashed-guaranty', [GuarantyController::class, 'trashed'])->name('guaranties.trashed');
Route::delete('guaranties/{id}/force-delete', [GuarantyController::class, 'forceDelete'])->name('guaranties.forceDelete');
Route::post('guaranties/{id}/restore', [GuarantyController::class, 'restore'])->name('guaranties.restore');

// --- Variants --- //
Route::get('products/{product}/variants', [ProductVariantController::class, 'index'])->name('variants.index');
Route::get('products/{product}/variants/create', [ProductVariantController::class, 'create'])->name('variants.create');
Route::post('products/{product}/variants', [ProductVariantController::class, 'store'])->name('variants.store');
Route::get('products/{product}/variants/{variant}/edit', [ProductVariantController::class, 'edit'])->name('variants.edit');
Route::put('products/{product}/variants/{variant}', [ProductVariantController::class, 'update'])->name('variants.update');
Route::delete('products/{product}/variants/{variant}', [ProductVariantController::class, 'destroy'])->name('variants.delete');

// --- Gallery --- //
Route::get('products/{product}/gallery/create', [ProductController::class, 'createGallery'])->name('galleries.create');
Route::post('products/{product}/gallery', [ProductController::class, 'storeGallery'])->name('galleries.store');
Route::delete('products/{product}/gallery/{gallery}', [ProductController::class, 'destroyGallery'])->name('galleries.delete');

// --- Property --- //
Route::resource('property_group', PropertyGroupController::class);

// --- Banner --- //
Route::get('/banner', [BannerAmazingController::class, 'edit'])->name('banner.edit');
Route::post('/banner', [BannerAmazingController::class, 'update'])->name('banner.update');

// --- Comments --- //
Route::get('users_comments', [CommentController::class, 'userComments'])->name('users.comments');
Route::patch('comments/{comment}/status', [CommentController::class, 'changeStatus'])->name('admin.comments.status');

// ========== مدیریت کد تخفیف‌ها ==========
Route::resource('discounts', DiscountController::class);

// مسیرهای اضافی برای سطل زباله تخفیف
Route::get('discounts/trashed', [DiscountController::class, 'trashed'])->name('discounts.trashed');
Route::patch('discounts/{id}/restore', [DiscountController::class, 'restore'])->name('discounts.restore');
Route::delete('discounts/{id}/force-delete', [DiscountController::class, 'forceDelete'])->name('discounts.force-delete');
Route::patch('discounts/{discount}/toggle-status', [DiscountController::class, 'toggleStatus'])->name('discounts.toggle-status');

// ========== مدیریت کارت هدیه‌ها (فقط یک بار تعریف شود) ==========
// استفاده از Route::resource به تنهایی کافی است
Route::resource('gift-cards', GiftCardController::class);

// مسیرهای اضافی برای سطل زباله کارت هدیه
Route::get('gift-cards/trashed', [GiftCardController::class, 'trashed'])->name('gift-cards.trashed');
Route::patch('gift-cards/{id}/restore', [GiftCardController::class, 'restore'])->name('gift-cards.restore');
Route::delete('gift-cards/{id}/force-delete', [GiftCardController::class, 'forceDelete'])->name('gift-cards.force-delete');
Route::patch('gift-cards/{giftCard}/toggle-status', [GiftCardController::class, 'toggleStatus'])->name('gift-cards.toggle-status');

Route::resource('orders', App\Http\Controllers\Admin\OrderController::class);
Route::put('orders/{order}/status', [App\Http\Controllers\Admin\OrderController::class, 'updateStatus'])->name('orders.update-status');
Route::get('orders/{order}/print', [App\Http\Controllers\Admin\OrderController::class, 'print'])->name('orders.print');
Route::get('orders-export', [App\Http\Controllers\Admin\OrderController::class, 'export'])->name('orders.export');

Route::resource('payment-gateways', App\Http\Controllers\Admin\PaymentGatewayController::class);

Route::get('payment-gateways/{payment_gateway}/activate',
    [App\Http\Controllers\Admin\PaymentGatewayController::class, 'activate']
)->name('payment-gateways.activate');

Route::prefix('payments')->name('payments.')->group(function () {
    Route::get('/', [PaymentController::class, 'index'])->name('index');
    Route::get('/export', [PaymentController::class, 'export'])->name('export');
    Route::get('/{payment}', [PaymentController::class, 'show'])->name('show');
    Route::delete('/{payment}', [PaymentController::class, 'destroy'])->name('destroy');
    Route::post('/{payment}/refund', [PaymentController::class, 'refund'])->name('refund');
    Route::post('/{payment}/retry-verify', [PaymentController::class, 'retryVerify'])->name('payments.retry-verify');
    Route::get('/statistics', [PaymentController::class, 'statistics'])->name('payments.statistics');
    Route::get('/{payment}/details', [PaymentController::class, 'getPaymentDetails'])->name('payments.details');
    Route::post('/{payment}/retry-verify', [PaymentController::class, 'retryVerify'])->name('retry-verify'); // اضافه کنید
});

