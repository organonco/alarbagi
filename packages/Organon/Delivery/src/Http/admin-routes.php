<?php

use Organon\Delivery\Http\Controllers\Shipping\DashboardController;
use Organon\Delivery\Http\Controllers\Shipping\SessionController;
use Organon\Delivery\Http\Controllers\Shipping\SettingsController;

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
        Route::get('/', DashboardController::class)->name('dashboard');
        Route::get('/settings', [SettingsController::class, 'index'])->name('settings');
        Route::post('/settings', [SettingsController::class, 'store'])->name('settings.store');
    });
});
