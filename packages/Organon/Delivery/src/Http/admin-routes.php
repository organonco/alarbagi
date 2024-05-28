<?php

use Organon\Delivery\Http\Controllers\Admin\DriverController;
use Organon\Delivery\Http\Controllers\Admin\PackageController;
use Organon\Delivery\Http\Controllers\Admin\WarehouseAdminController;
use Organon\Delivery\Http\Controllers\Admin\WarehouseController;
use Organon\Delivery\Http\Controllers\Driver\DashboardController as DriverDashboardController;
use Organon\Delivery\Http\Controllers\Driver\SessionController as DriverSessionController;
use Organon\Delivery\Http\Controllers\WarehouseAdmin\DashboardController;
use Organon\Delivery\Http\Controllers\WarehouseAdmin\SessionController;

Route::group([
    'prefix'        => 'admin',
    'as' => 'admin.delivery.',
    'middleware'    => ['web'],
], function () {
    Route::group(['prefix' => 'delivery', 'middleware' => ['admin']], function () {

        Route::group(['prefix' => 'warehouses'], function () {
            Route::get('', [WarehouseController::class, 'index'])->name('warehouses.index');
            Route::get('create', [WarehouseController::class, 'create'])->name('warehouses.create');
            Route::post('create', [WarehouseController::class, 'store'])->name('warehouses.store');
            Route::get('edit/{id}', [WarehouseController::class, 'edit'])->name('warehouses.edit');
            Route::post('edit/{id}', [WarehouseController::class, 'update'])->name('warehouses.update');
        });


        Route::group(['prefix' => 'warehouse_admins'], function () {
            Route::get('', [WarehouseAdminController::class, 'index'])->name('warehouse_admins.index');
            Route::get('create', [WarehouseAdminController::class, 'create'])->name('warehouse_admins.create');
            Route::post('create', [WarehouseAdminController::class, 'store'])->name('warehouse_admins.store');
            Route::get('edit/{id}', [WarehouseAdminController::class, 'edit'])->name('warehouse_admins.edit');
            Route::post('edit/{id}', [WarehouseAdminController::class, 'update'])->name('warehouse_admins.update');
            Route::post('edit-password/{id}', [WarehouseAdminController::class, 'updatePassword'])->name('warehouse_admins.update_password');
        });


        Route::group(['prefix' => 'drivers'], function () {
            Route::get('', [DriverController::class, 'index'])->name('drivers.index');
            Route::get('create', [DriverController::class, 'create'])->name('drivers.create');
            Route::post('create', [DriverController::class, 'store'])->name('drivers.store');
            Route::get('edit/{id}', [DriverController::class, 'edit'])->name('drivers.edit');
            Route::post('edit/{id}', [DriverController::class, 'update'])->name('drivers.update');
            Route::post('edit-password/{id}', [DriverController::class, 'updatePassword'])->name('drivers.update_password');
        });

        Route::group(['prefix' => 'packages'], function () {
            Route::get('/{hash}', [PackageController::class, 'view'])->name('packages.view');
        });
    });
});


Route::group([
    'prefix'        => 'admin/warehouse',
    'as' => 'warehouse.',
    'middleware'    => ['web'],
], function () {
    Route::get('login', [SessionController::class, 'create'])->name('session.create');
    Route::post('login', [SessionController::class, 'store'])->name('session.store');

    Route::group(['prefix' => '', 'middleware' => ['admin:warehouse_admin']], function () {
        Route::get('/', DashboardController::class)->name('dashboard');
    });
});




Route::group([
    'prefix'        => 'admin/driver',
    'as' => 'driver.',
    'middleware'    => ['web'],
], function () {
    Route::get('login', [DriverSessionController::class, 'create'])->name('session.create');
    Route::post('login', [DriverSessionController::class, 'store'])->name('session.store');

    Route::group(['prefix' => '', 'middleware' => ['admin:driver']], function () {
        Route::get('/', DriverDashboardController::class)->name('dashboard');
    });
});
