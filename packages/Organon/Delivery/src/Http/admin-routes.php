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
});
