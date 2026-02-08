<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\WebController;
use App\Http\Controllers\AboutController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\AdminController;
use App\Livewire\Cart\CartIndex;
use App\Livewire\Checkout\CheckoutForm;
use App\Livewire\Products\ProductList;
use App\Livewire\Products\ProductDetail;

// Public routes
Route::get('/', [WebController::class, 'home']);
Route::get('/about', [AboutController::class, 'index'])->name('about');
Route::get('/products', ProductList::class)->name('products.index');
Route::get('/products/{productId}', ProductDetail::class)->name('products.show');

// Authentication routes are now handled by Jetstream/Fortify

// Dashboard route (required by Jetstream navigation)
Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->get('/dashboard', function () {
    return redirect('/');
})->name('dashboard');

// Protected user routes (require authentication)
Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {
    Route::get('/cart', CartIndex::class)->name('cart.index');
    Route::get('/checkout', CheckoutForm::class)->name('checkout.index');
    Route::get('/wishlist', \App\Livewire\Wishlist\WishlistIndex::class)->name('wishlist.index');
    Route::post('/wishlist/toggle', [App\Http\Controllers\WishlistController::class, 'toggle'])->name('wishlist.toggle');
    Route::get('/wishlist/count', [App\Http\Controllers\WishlistController::class, 'count'])->name('wishlist.count');
    Route::get('/orders', [UserController::class, 'orders'])->name('orders.index');
    Route::get('/orders/{id}', [UserController::class, 'orderShow'])->name('orders.show');
    Route::get('/orders/{orderId}/track', \App\Livewire\OrderTracking::class)->name('orders.track');
    Route::post('/cart/add', [UserController::class, 'addToCart'])->name('cart.add'); // Keep for form submission
    Route::post('/products/{id}/reviews', [UserController::class, 'storeReview'])->name('reviews.store');
});

// Admin routes (require authentication + admin role)
Route::middleware(['auth', 'admin'])->prefix('admin')->group(function () {
    Route::get('/', \App\Livewire\Admin\Dashboard::class)->name('admin.dashboard');
    Route::get('/users', \App\Livewire\Admin\Users::class)->name('admin.users');
    Route::get('/payments', \App\Livewire\Admin\Payments::class)->name('admin.payments');
    Route::get('/orders', \App\Livewire\Admin\OrderManagement::class)->name('admin.orders');
    Route::get('/orders/{id}', [AdminController::class, 'orderShow'])->name('admin.orders.show');
    Route::get('/reports', \App\Livewire\Admin\Reports::class)->name('admin.reports');
    Route::get('/products', \App\Livewire\Admin\ProductTable::class)->name('admin.products');
    Route::get('/products/create', \App\Livewire\Admin\ProductForm::class)->name('admin.products.create');
    Route::get('/products/{product}/edit', \App\Livewire\Admin\ProductForm::class)->name('admin.products.edit');
    Route::get('/categories', \App\Livewire\Admin\CategoryManagement::class)->name('admin.categories.index');
    Route::get('/settings', \App\Livewire\Admin\Settings::class)->name('admin.settings');
    Route::get('/audit-logs', \App\Livewire\Admin\AuditLogs::class)->name('admin.audit-logs');
});

// Payment Routes
Route::middleware(['auth'])->group(function () {
    Route::get('/payment/success', [App\Http\Controllers\PaymentController::class, 'success'])->name('payment.success');
    Route::get('/payment/cancel', [App\Http\Controllers\PaymentController::class, 'cancel'])->name('payment.cancel');
});

// Stripe Webhook (no CSRF protection needed)
Route::post('/stripe/webhook', [App\Http\Controllers\StripeWebhookController::class, 'handleWebhook'])->withoutMiddleware([\App\Http\Middleware\VerifyCsrfToken::class]);
