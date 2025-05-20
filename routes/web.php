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


Auth::routes();

Route::group(['middleware' => ['auth', 'access.application']], function () {
  Route::get('/', 'HomeController@index');
  Route::get('/home', 'HomeController@index');


    Route::group(['prefix' => 'master', 'namespace' => 'Master'], function () {
        // Route khusus untuk update dengan metode POST
        Route::post('/banner/{id}', 'BannerController@update')->middleware('access.menu:master/banner');
        

        Route::post('/clinic/{id}', 'ClinicController@update')->middleware('access.menu:master/clinic');
        Route::post('/doctor/{id}', 'DoctorController@update')->middleware('access.menu:master/doctor');
        Route::post('/guide/{id}', 'GuideController@update')->middleware('access.menu:master/guide');
        Route::post('/product/{id}', 'ProductController@update')->middleware('access.menu:master/product');

        // Resource routes untuk semua controller
        Route::resource('/banner', 'BannerController')->middleware('access.menu:master/banner');
        

        Route::resource('/clinic', 'ClinicController')->middleware('access.menu:master/clinic');
        Route::resource('/doctor', 'DoctorController')->middleware('access.menu:master/doctor');
        Route::resource('/guide', 'GuideController')->middleware('access.menu:master/guide');
        Route::resource('/product', 'ProductController')->middleware('access.menu:master/product');



        Route::group(['prefix' => 'employee', 'namespace' => 'Employee'], function () {
            Route::resource('/role', 'EmployeeRoleController')->middleware('access.menu:master/employee/role');

            Route::get('/{id}/edit', 'EmployeeController@edit')->middleware('access.menu:master/employee');
            Route::post('/{id}', 'EmployeeController@update')->middleware('access.menu:master/employee');
            Route::delete('/{id}', 'EmployeeController@destroy')->middleware('access.menu:master/employee');
            Route::resource('/', 'EmployeeController')->middleware('access.menu:master/employee');
        });
    });
    
        Route::group(['prefix' => 'history', 'namespace' => 'History'], function () {
            Route::resource('/history-purchase', 'HistoryPurchaseController')->middleware('access.menu:history/history-purchase');
            Route::resource('/history-scan', 'HistoryScanController')->middleware('access.menu:history/history-scan');
            Route::resource('/history-reservation', 'HistoryReservationController')->middleware('access.menu:history/history-reservation');
            
            Route::patch('/reservations/{reservation}/note', 'HistoryReservationController@updateNote')->name('reservations.note')->middleware('access.menu:history/history-reservation');
            
            Route::put('/purchases/{id}/update-status', 'HistoryPurchaseController@updateStatus')->name('purchases.update-status');


        });
        
        // routes/web.php



});