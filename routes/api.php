<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

// Import Controllers
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\KlinikController;
use App\Http\Controllers\CheckoutController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

// Customer Authentication & Profile Routes
Route::prefix('customer')->group(function () {
    // Registration & Login (tidak perlu auth)
    Route::post('sign-up', [CustomerController::class, 'store']);
    Route::post('sign-in', [CustomerController::class, 'signIn']);
    
    // Profile Management (perlu auth)
    Route::middleware('auth:api')->group(function () {
        Route::post('sign-out', [CustomerController::class, 'signOut']);
        Route::get('profile', [CustomerController::class, 'show']); // Ini yang akan return phone number
        Route::put('profile', [CustomerController::class, 'update']);
    });
    
    // Upload thumbnail (tidak perlu auth karena pakai user_id di request)
    Route::post('update-thumbnail', [CustomerController::class, 'updateThumbnail']);
});

// Klinik & Medical Data Routes
Route::get('product', [KlinikController::class, 'getProducts']);
Route::get('clinic', [KlinikController::class, 'getClinics']);
Route::get('doctors', [KlinikController::class, 'getDoctors']);
Route::get('dog-care-guides', [KlinikController::class, 'getDogCareGuides']);
Route::get('ectoparasite-diseases', [KlinikController::class, 'getEctoparasiteDiseases']);
Route::get('ras', [KlinikController::class, 'getRas']); // Jika ada endpoint ini

// Scan & Reservation Routes
Route::post('submit-scan', [KlinikController::class, 'submitScan']);
Route::get('scan/{user_id}', [KlinikController::class, 'historyScan']);

Route::post('reservations/create', [KlinikController::class, 'createReservation']);
Route::get('reservations/{user_id}', [KlinikController::class, 'historyReservation']);

// E-commerce Routes
Route::post('checkout', [CheckoutController::class, 'processCheckout']);
Route::get('orders/{user_id}', [CheckoutController::class, 'getOrderHistory']);

// Fallback route untuk user authentication check
Route::middleware('auth:api')->get('/user', function (Request $request) {
    $user = $request->user();
    $profile = $user->profile;
    
    return response()->json([
        'id' => $user->id,
        'name' => $user->name,
        'email' => $user->email,
        'phone' => $profile->phone ?? null, // PASTIKAN PHONE MUNCUL DI SINI JUGA
        'role_id' => $user->role_id,
        'image_url' => $profile->image ? asset('storage/' . $profile->image) : null,
        'token_api' => $user->token_api,
        'is_scan' => $profile->is_scan ?? 0
    ]);
});