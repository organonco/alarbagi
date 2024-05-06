<?php

Route::group([
        'prefix'        => 'admin/delivery',
        'middleware'    => ['web', 'admin']
    ], function () {

        Route::get('', 'Organon\Delivery\Http\Controllers\Admin\DeliveryController@index')->defaults('_config', [
            'view' => 'delivery::admin.index',
        ])->name('admin.delivery.index');

});