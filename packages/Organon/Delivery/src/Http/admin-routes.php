<?php

use Organon\Delivery\Http\Controllers\Shipping\DashboardController;
use Organon\Delivery\Http\Controllers\Shipping\DriverController;
use Organon\Delivery\Http\Controllers\Shipping\OrderController;
use Organon\Delivery\Http\Controllers\Shipping\SessionController;
use Organon\Delivery\Http\Controllers\Shipping\SettingsController;
use Organon\Delivery\Http\Controllers\Shipping\ShowOrderController;

Route::group([
    'prefix'        => config('app.admin_url') . '/delivery',
    'middleware'    => ['web', 'admin']
], function () {

    Route::group(['prefix' => "area"], function () {
        Route::get('', 'Organon\Delivery\Http\Controllers\Admin\AreaController@index')->name('admin.delivery.area.index');
        Route::get('create', 'Organon\Delivery\Http\Controllers\Admin\AreaController@create')->name('admin.delivery.area.create');
        Route::post('create', 'Organon\Delivery\Http\Controllers\Admin\AreaController@store')->name('admin.delivery.area.store');
        Route::get('/{id}', 'Organon\Delivery\Http\Controllers\Admin\AreaController@edit')->name('admin.delivery.area.edit');
        Route::post('/{id}', 'Organon\Delivery\Http\Controllers\Admin\AreaController@update')->name('admin.delivery.area.update');
    });

    Route::group(['prefix' => "shipping-companies"], function () {
        Route::get('', 'Organon\Delivery\Http\Controllers\Admin\ShippingCompanyController@index')->name('admin.delivery.shipping-company.index');
        Route::get('create', 'Organon\Delivery\Http\Controllers\Admin\ShippingCompanyController@create')->name('admin.delivery.shipping-company.create');
        Route::post('create', 'Organon\Delivery\Http\Controllers\Admin\ShippingCompanyController@store')->name('admin.delivery.shipping-company.store');
        Route::get('/{id}', 'Organon\Delivery\Http\Controllers\Admin\ShippingCompanyController@edit')->name('admin.delivery.shipping-company.edit');
        Route::post('/{id}', 'Organon\Delivery\Http\Controllers\Admin\ShippingCompanyController@update')->name('admin.delivery.shipping-company.update');
    });
});


Route::group([
    'prefix'        => config('app.admin_url') . '/shipping',
    'as' => 'shipping.',
    'middleware'    => ['web'],
], function () {
    Route::get('login', [SessionController::class, 'create'])->name('session.create');
    Route::post('login', [SessionController::class, 'store'])->name('session.store');
    Route::post('logout', [SessionController::class, 'destroy'])->name('session.destroy');
    
    Route::group(['prefix' => '', 'middleware' => ['admin:shipping']], function () {
		Route::get('/settings', [SettingsController::class, 'index'])->name('settings');
        Route::post('/settings', [SettingsController::class, 'store'])->name('settings.store');
        Route::get('/driver', [DriverController::class, 'index'])->name('driver.index');
        Route::get('/driver/create', [DriverController::class, 'create'])->name('driver.create');
        Route::post('/driver/create', [DriverController::class, 'store'])->name('driver.store');
        Route::get('/driver/{id}', [DriverController::class, 'edit'])->name('driver.edit');
        Route::post('/driver/{id}', [DriverController::class, 'update'])->name('driver.update');


        Route::get('/', [OrderController::class, 'index'])->name('dashboard');
		Route::get('/order/{id}', [OrderController::class, 'show'])->name('orders.show');
		Route::put('/order/{id}/update-shipping', [OrderController::class, 'updateShippingPrice'])->name('orders.update-shipping');
		Route::put('/order/{id}/mark-as-shipping', [OrderController::class, 'markAsShipping'])->name('orders.mark-as-shipping');
		Route::put('/order/{id}/mark-as-complete', [OrderController::class, 'markAsComplete'])->name('orders.mark-as-complete');
    });
});
