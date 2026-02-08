<?php

use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\ProductApiController;
use App\Http\Controllers\Api\CategoryApiController;
use App\Http\Controllers\Api\CartApiController;
use App\Http\Controllers\Api\OrderApiController;
use App\Http\Controllers\Api\ReviewApiController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Hash;

/*
|--------------------------------------------------------------------------
| API Routes - DEPRECATED
|--------------------------------------------------------------------------
|
| NOTICE: Most of these API routes are DEPRECATED as of the Livewire migration.
| The application now uses Livewire components for all user interactions.
| These routes are kept for backward compatibility and potential external API usage.
|
| Active Routes:
| - Public product/category listing (for potential mobile app or external integrations)
| - Admin statistics endpoint
|
| Deprecated Routes:
| - Cart management (now handled by Livewire CartIndex component)
| - Order creation (now handled by Livewire CheckoutForm component)
| - Product CRUD (now handled by Livewire Admin components)
|
*/

// ============================================================================
// PUBLIC API ROUTES (Active - for external integrations)
// ============================================================================

// Public product and category routes
Route::get('/products', [ProductApiController::class, 'index']);
Route::get('/products/{id}', [ProductApiController::class, 'show']);
Route::get('/categories', [CategoryApiController::class, 'index']);
Route::get('/categories/{id}', [CategoryApiController::class, 'show']);

// Public reviews routes
Route::get('/reviews', [ReviewApiController::class, 'index']);

// ============================================================================
// DEPRECATED ROUTES (Kept for backward compatibility)
// ============================================================================

// Auth routes - DEPRECATED (use Laravel Fortify/Jetstream session auth)
Route::post('/register', [AuthController::class, 'register']); // DEPRECATED
Route::post('/login', [AuthController::class, 'login']); // DEPRECATED

// Protected routes (require authentication)
Route::middleware('auth:sanctum')->group(function () {
    // Auth routes - DEPRECATED
    Route::post('/logout', [AuthController::class, 'logout']); // DEPRECATED
    Route::get('/user', [AuthController::class, 'user']); // DEPRECATED

    // Cart routes - DEPRECATED (use Livewire CartIndex component)
    Route::get('/cart', [CartApiController::class, 'index']); // DEPRECATED
    Route::post('/cart/items', [CartApiController::class, 'addItem']); // DEPRECATED
    Route::put('/cart/items/{id}', [CartApiController::class, 'updateItem']); // DEPRECATED
    Route::delete('/cart/items/{id}', [CartApiController::class, 'removeItem']); // DEPRECATED
    Route::delete('/cart/clear', [CartApiController::class, 'clear']); // DEPRECATED

    // Order routes - DEPRECATED (use Livewire CheckoutForm component)
    Route::get('/orders', [OrderApiController::class, 'index']); // DEPRECATED
    Route::post('/orders', [OrderApiController::class, 'store']); // DEPRECATED
    Route::get('/orders/{id}', [OrderApiController::class, 'show']); // DEPRECATED

    // Review routes - DEPRECATED (use Livewire ProductDetail component)
    Route::post('/reviews', [ReviewApiController::class, 'store']); // DEPRECATED
    Route::put('/reviews/{id}', [ReviewApiController::class, 'update']); // DEPRECATED
    Route::delete('/reviews/{id}', [ReviewApiController::class, 'destroy']); // DEPRECATED
});

// ============================================================================
// ADMIN API ROUTES
// ============================================================================

// Admin routes (support both session and token auth)
Route::middleware(['web', 'auth', 'admin'])->group(function () {
    // Statistics endpoint - ACTIVE (used for dashboards/reports)
    Route::get('/orders/statistics/admin', [OrderApiController::class, 'statistics']);

    // Product management - DEPRECATED (use Livewire Admin\ProductForm component)
    Route::post('/products', [ProductApiController::class, 'store']); // DEPRECATED
    Route::put('/products/{id}', [ProductApiController::class, 'update']); // DEPRECATED
    Route::delete('/products/{id}', [ProductApiController::class, 'destroy']); // DEPRECATED
    Route::get('/products/low-stock/alert', [ProductApiController::class, 'lowStock']); // DEPRECATED

    // Category management - DEPRECATED (use Livewire Admin\CategoryManagement component)
    Route::post('/categories', [CategoryApiController::class, 'store']); // DEPRECATED
    Route::put('/categories/{id}', [CategoryApiController::class, 'update']); // DEPRECATED
    Route::delete('/categories/{id}', [CategoryApiController::class, 'destroy']); // DEPRECATED

    // Order management - DEPRECATED (use Livewire Admin\OrderManagement component)
    Route::put('/orders/{id}/status', [OrderApiController::class, 'updateStatus']); // DEPRECATED
});


// ============================================================================
// NEW: SANCTUM PROTECTED API ROUTES
// ============================================================================

// 1. Login Route to get Token
Route::post('/auth/token', function (Request $request) {
    $request->validate([
        'email' => 'required|email',
        'password' => 'required',
        'device_name' => 'required',
    ]);

    $user = \App\Models\User::where('email', $request->email)->first();

    if (! $user || ! Hash::check($request->password, $user->password)) {
        return response()->json(['message' => 'Invalid credentials'], 401);
    }

    // Create a robust token
    $token = $user->createToken($request->device_name)->plainTextToken;

    return response()->json(['token' => $token]);
});

// 2. Protected Routes (require 'Authorization: Bearer <token>')
Route::middleware('auth:sanctum')->group(function () {
    
    // Example: Get current user
    Route::get('/user/profile', function (Request $request) {
        return $request->user();
    });

    // Example: Your protected API endpoints here
    // Route::get('/my-orders', ...);
});
