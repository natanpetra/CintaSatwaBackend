<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

// Authentication Routes
Auth::routes();

// Protected Routes - Require Authentication
Route::group(['middleware' => ['auth', 'access.application']], function () {
    
    // Dashboard/Home Routes
    Route::get('/', 'HomeController@index');
    Route::get('/home', 'HomeController@index');

    // Master Data Routes
    Route::group(['prefix' => 'master', 'namespace' => 'Master'], function () {
        
        // Clinic Routes
        Route::post('/clinic/{id}', 'ClinicController@update')->middleware('access.menu:master/clinic');
        Route::resource('/clinic', 'ClinicController')->middleware('access.menu:master/clinic');

        // Doctor Routes
        Route::post('/doctor/{id}', 'DoctorController@update')->middleware('access.menu:master/doctor');
        Route::resource('/doctor', 'DoctorController')->middleware('access.menu:master/doctor');

        // Dog Care Guide Routes
        Route::post('/guide/{id}', 'GuideController@update')->middleware('access.menu:master/guide');
        Route::resource('/guide', 'GuideController')->middleware('access.menu:master/guide');

        // Ectoparasite Routes
        Route::post('/ectoparasite/{id}', 'EctoparasiteController@update')->middleware('access.menu:master/ectoparasite');
        Route::resource('/ectoparasite', 'EctoparasiteController')->middleware('access.menu:master/ectoparasite');

        // Product Routes
        Route::post('/product/{id}', 'ProductController@update')->middleware('access.menu:master/product');
        Route::resource('/product', 'ProductController')->middleware('access.menu:master/product');

        // Employee Management Routes
        Route::group(['prefix' => 'employee', 'namespace' => 'Employee'], function () {
            // Employee Role Routes
            Route::resource('/role', 'EmployeeRoleController')->middleware('access.menu:master/employee/role');

            // Employee Routes
            Route::get('/{id}/edit', 'EmployeeController@edit')->middleware('access.menu:master/employee');
            Route::post('/{id}', 'EmployeeController@update')->middleware('access.menu:master/employee');
            Route::delete('/{id}', 'EmployeeController@destroy')->middleware('access.menu:master/employee');
            Route::resource('/', 'EmployeeController')->middleware('access.menu:master/employee');
        });
    });
    
    // History/Report Routes
    Route::group(['prefix' => 'history', 'namespace' => 'History'], function () {
        
        // History Purchase Routes
        Route::get('/history-purchase/export-pdf', 'HistoryPurchaseController@exportPdf')->name('history-purchase.export-pdf');
        Route::put('/purchases/{id}/update-status', 'HistoryPurchaseController@updateStatus')->name('purchases.update-status');
        Route::resource('/history-purchase', 'HistoryPurchaseController')->middleware('access.menu:history/history-purchase');
        
        // History Scan Routes
        Route::get('/history-scan/export-pdf', 'HistoryScanController@exportPdf')->name('history-scan.export-pdf');
        Route::patch('/scans/{scan}/note', 'HistoryScanController@updateNote')->name('scans.note');
        Route::resource('/history-scan', 'HistoryScanController')->middleware('access.menu:history/history-scan');
        
        // History Reservation Routes
        Route::get('/history-reservation/export-pdf', 'HistoryReservationController@exportPdf')->name('history-reservation.export-pdf');
        Route::patch('/reservations/{reservation}/note', 'HistoryReservationController@updateNote')->name('reservations.note')->middleware('access.menu:history/history-reservation');
        Route::resource('/history-reservation', 'HistoryReservationController')->middleware('access.menu:history/history-reservation');
    });

    // Dashboard Data Routes (untuk AJAX load data di dashboard)
    Route::group(['prefix' => 'dashboard'], function () {
        Route::get('/stats', 'HomeController@getStats');
        Route::get('/recent-orders', 'HomeController@getRecentOrders');
        Route::get('/inventory-status', 'HomeController@inventoryDatatable');
    });

    // Additional Utility Routes
    Route::group(['prefix' => 'utility'], function () {
        // Search Routes (untuk AJAX search)
        Route::post('/search/clinic', 'Master\ClinicController@search');
        Route::post('/search/doctor', 'Master\DoctorController@search');
        Route::post('/search/product', 'Master\ProductController@search');
        Route::post('/search/purchase', 'History\HistoryPurchaseController@search');
        Route::post('/search/reservation', 'History\HistoryReservationController@search');
        Route::post('/search/scan', 'History\HistoryScanController@search');
        
        // Quick Access Routes
        Route::get('/clinic/{id}', 'Master\ClinicController@searchById');
        Route::get('/doctor/{id}', 'Master\DoctorController@searchById');
        Route::get('/product/{id}', 'Master\ProductController@searchById');
        Route::get('/purchase/{id}', 'History\HistoryPurchaseController@searchById');
        Route::get('/reservation/{id}', 'History\HistoryReservationController@searchById');
        Route::get('/scan/{id}', 'History\HistoryScanController@searchById');
    });
});

// Public Routes (tidak perlu login)
Route::group(['prefix' => 'public'], function () {
    // Public API untuk mobile app bisa diakses tanpa web auth
    Route::get('/clinic-info', 'KlinikController@getClinics');
    Route::get('/doctors', 'KlinikController@getDoctors');
    Route::get('/products', 'KlinikController@getProducts');
    Route::get('/dog-care-guides', 'KlinikController@getDogCareGuides');
    Route::get('/ectoparasite-diseases', 'KlinikController@getEctoparasiteDiseases');
});

// Customer Verification Routes (tidak perlu auth)
Route::get('/customer/verification/{verification_code}', 'CustomerController@verificationEmail');

// AJAX Routes untuk DataTables dan Utility Functions
Route::group(['prefix' => 'ajax', 'middleware' => ['auth']], function () {
    Route::get('/service', 'AjaxController@service');
    Route::post('/antrian/save-token', 'AntrianController@saveToken');
    Route::post('/antrian/panggil', 'PanggilanController@panggilAntrian');
});

// Public Display Routes (untuk tampilan umum seperti antrian)
Route::group(['prefix' => 'display'], function () {
    Route::get('/antrian', 'AntrianController@index');
    Route::get('/beranda', 'BerandaController@index');
    Route::get('/instansi/{id}', 'BerandaController@instance');
    Route::post('/ambil-antrian', 'BerandaController@ambilantrian');
    Route::get('/cetak-nomor/{id}', 'BerandaController@cetaknomor')->name('beranda.cetaknomor');
});

// Error Testing Routes (hanya untuk development)
if (app()->environment('local')) {
    Route::get('/test-error', function () {
        throw new Exception('Test error page');
    });
    
    Route::get('/test-db', function () {
        try {
            \DB::connection()->getPdo();
            return 'Database connection successful';
        } catch (\Exception $e) {
            return 'Database connection failed: ' . $e->getMessage();
        }
    });

    Route::get('/test-pdf', function () {
        try {
            $pdf = \PDF::loadHTML('<h1>Test PDF</h1><p>PDF generation is working!</p>');
            return $pdf->download('test.pdf');
        } catch (\Exception $e) {
            return 'PDF generation failed: ' . $e->getMessage();
        }
    });
}