<?php

use Organon\Delivery\Http\Controllers\Shop\WarehouseController;

Route::group([
    'prefix'        => 'admin/delivery',
    'middleware'    => ['web', 'admin']
], function () {

    Route::group(['prefix' => 'warehouses'], function () {
        Route::get('', [WarehouseController::class, 'index'])
            ->name('admin.delivery.warehouses.index');

        Route::get('create', [WarehouseController::class, 'create'])
            ->name('admin.delivery.warehouses.create');

        Route::post('create', [WarehouseController::class, 'store'])
            ->name('admin.delivery.warehouses.store');

        Route::get('edit/{id}', [WarehouseController::class, 'edit'])
            ->name('admin.delivery.warehouses.edit');

        Route::post('edit/{id}', [WarehouseController::class, 'update'])
            ->name('admin.delivery.warehouses.update');
    });
});
