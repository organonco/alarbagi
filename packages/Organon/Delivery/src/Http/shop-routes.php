<?php

Route::group([
        'prefix'     => 'delivery',
        'middleware' => ['web', 'theme', 'locale', 'currency']
    ], function () {

        Route::get('/', 'Organon\Delivery\Http\Controllers\Shop\DeliveryController@index')->defaults('_config', [
            'view' => 'delivery::shop.index',
        ])->name('shop.delivery.index');

});