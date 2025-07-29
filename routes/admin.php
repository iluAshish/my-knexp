<?php

use App\Http\Controllers\AboutUsController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\DateLockDateController;
use App\Http\Controllers\EnquiryController;
use App\Http\Controllers\KeyFeatureController;
use App\Http\Controllers\SliderController;
use App\Http\Controllers\ServiceController;
use App\Http\Controllers\SiteInformationController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\WhyChooseUsController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\BranchController;
use App\Http\Controllers\DateLockWeekController;
use App\Http\Controllers\OrderController;

Route::middleware(['permissionsWeb', 'auth'])->group(function () {

    Route::get('/users', 'UserController@list')->name('user.list');
    Route::resource('/user', UserController::class);
    Route::get('/user-export', 'UserController@export')->name('user.export');

    Route::get('/orders', 'OrderController@list')->name('order.list');
    Route::post('/order/update-shipment-status', 'OrderController@updateShipmentStatus')->name('order.updateShipmentStatus');
    Route::post('/order/update-shipment-status-bulk', 'OrderController@updateShipmentStatusBulk')->name('order.updateShipmentStatusBulk');
    Route::resource('/order', OrderController::class);
    Route::get('/order-export', 'OrderController@export')->name('order.export');

    Route::get('/shipments', 'ShipmentController@list')->name('shipment.list');
    Route::post('/shipment/bulk-delete', 'ShipmentController@bulkDelete')->name('shipment.bulkDelete');
    Route::resource('/shipment', \App\Http\Controllers\ShipmentController::class);

    Route::get('/customers', 'CustomerController@list')->name('customer.list');
    Route::resource('/customer', CustomerController::class);
    Route::get('/customer-export', 'CustomerController@export')->name('customer.export');

    Route::get('/branches', 'BranchController@list')->name('branch.list');
    Route::resource('/branch', BranchController::class);

    Route::get('/dates', 'DateLockDateController@list')->name('date.list');
    Route::resource('/date', DateLockDateController::class);

    Route::get('/days', 'DateLockWeekController@list')->name('day.list');
    Route::resource('/day', DateLockWeekController::class);

    Route::resource('/role', \App\Http\Controllers\RoleController::class);

    Route::resource('/permission', \App\Http\Controllers\PermissionController::class);

    Route::resource('/dashboard', DashboardController::class);

    Route::resource('/service', ServiceController::class);

    Route::post('/sortOrder', 'HomeController@sortOrder');

    Route::resource('/home/slider', SliderController::class);

    Route::resource('/home/about-us', AboutUsController::class);

    Route::resource('/home/keyfeature', KeyFeatureController::class);

    Route::resource('/home/whychooseus', WhyChooseUsController::class);

    Route::resource('/siteinformation', SiteInformationController::class);

    Route::get('/enquiries', 'EnquiryController@list')->name('enquiry.list');
    Route::resource('/enquiry', EnquiryController::class);

    Route::post('/enquiry/bulk-delete', 'EnquiryController@bulkDelete')->name('enquiry.bulkDelete');
    Route::post('/enquiries/enquiryReply', 'EnquiryController@enquiryReply')->name('enquiry.replay');

    Route::get('/reports', 'ReportController@list')->name('report.list');
    Route::resource('/report', \App\Http\Controllers\ReportController::class);
    Route::get('/report-export', 'ReportController@export')->name('report.export');

    Route::get('/delivery-comments', 'DeliveryCommentController@list')->name('deliverycomment.list');
    Route::resource('/delivery-comment', \App\Http\Controllers\DeliveryCommentController::class);
    Route::post('/delivery-comment/update-shipment-status', 'DeliveryCommentController@updateShipmentStatus')->name('deliverycomment.updateshipmentstatus');

    Route::get('/notifications', 'NotificationController@list')->name('notification.list');
    Route::resource('/notification', \App\Http\Controllers\NotificationController::class);
    Route::get('/notification-export', 'NotificationController@export')->name('notification.export');

});
Route::post('/status-change', 'HomeController@statusChange')->middleware('auth');
