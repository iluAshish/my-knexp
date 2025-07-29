<?php

use App\Services\SmsGlobalService;
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


Route::get('/', 'WebController@index');
Route::get('/thankyou', 'WebController@thankyou')->name('thankyou');
Route::post('/enquiry-form', 'WebController@enquiry_form')->name('enquiry.form');

// Tracking id (search)
Route::post('/search', 'WebController@search')->name('web.search');

Route::get('/admin', [\App\Http\Controllers\Auth\AuthController::class, 'showLoginForm'])->name('admin');

Route::post('/admin/customer/check', [\App\Http\Controllers\CustomerController::class, 'checkCustomerAlreadyExist'])->name('customer.check');
