<?php

use Illuminate\Http\Request;
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

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::post('customer/sign-in', 'CustomerController@signIn');
Route::post('customer/sign-up', 'CustomerController@store');
Route::post('customer/update-thumbnail', 'CustomerController@updateThumbnail');


Route::get('/clinics', [KlinikController::class, 'getClinics']);
Route::get('/consultations', [KlinikController::class, 'getConsultations']);
Route::get('/consultation-history', [KlinikController::class, 'getConsultationHistory']);
Route::get('/doctors', [KlinikController::class, 'getDoctors']);
Route::get('/dog-care-guides', [KlinikController::class, 'getDogCareGuides']);
Route::get('/ectoparasite-diseases', [KlinikController::class, 'getEctoparasiteDiseases']);
Route::get('/medical-records', [KlinikController::class, 'getMedicalRecords']);
Route::get('/product', [KlinikController::class, 'getProducts']);
Route::post('/submit-scan', [KlinikController::class, 'submitScan']);

Route::post('/checkout', [CheckoutController::class, 'processCheckout']);
Route::get('/orders/{userId}', [CheckoutController::class, 'getOrderHistory']);

Route::post('reservations/create', [KlinikController::class, 'createReservation']);
Route::get('reservations/{user_id}', [KlinikController::class, 'historyReservation']);

Route::get('scan/{user_id}', [KlinikController::class, 'historyScan']);


Route::get('/riwayat-pemeriksaan', [KlinikController::class, 'getRiwayatPemeriksaan']);

Route::get('/riwayat-konsultasi', [KlinikController::class, 'getRiwayatKonsultasi']);

Route::get('/riwayat-pembelian', [KlinikController::class, 'getRiwayatPembelian']);