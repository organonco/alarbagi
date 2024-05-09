<?php

use Organon\Delivery\Http\Controllers\Admin\WarehouseAdminController;
use Organon\Delivery\Http\Controllers\Admin\WarehouseController;

Route::group([
    'prefix'        => 'admin/delivery',
    'middleware'    => ['web', 'admin'],
], function () {

    Route::group(['prefix' => 'warehouses'], function () {
        Route::get('', [WarehouseController::class, 'index'])->name('admin.delivery.warehouses.index');
        Route::get('create', [WarehouseController::class, 'create'])->name('admin.delivery.warehouses.create');
        Route::post('create', [WarehouseController::class, 'store'])->name('admin.delivery.warehouses.store');
        Route::get('edit/{id}', [WarehouseController::class, 'edit'])->name('admin.delivery.warehouses.edit');
        Route::post('edit/{id}', [WarehouseController::class, 'update'])->name('admin.delivery.warehouses.update');
    });


    Route::group(['prefix' => 'warehouse_admins'], function () {
        Route::get('', [WarehouseAdminController::class, 'index'])->name('admin.delivery.warehouse_admins.index');
        Route::get('create', [WarehouseAdminController::class, 'create'])->name('admin.delivery.warehouse_admins.create');
        Route::post('create', [WarehouseAdminController::class, 'store'])->name('admin.delivery.warehouse_admins.store');
        Route::get('edit/{id}', [WarehouseAdminController::class, 'edit'])->name('admin.delivery.warehouse_admins.edit');
        Route::post('edit/{id}', [WarehouseAdminController::class, 'update'])->name('admin.delivery.warehouse_admins.update');
        Route::post('edit-password/{id}', [WarehouseAdminController::class, 'updatePassword'])->name('admin.delivery.warehouse_admins.update_password');
    });
});
