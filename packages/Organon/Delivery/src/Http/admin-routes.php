<?php

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
