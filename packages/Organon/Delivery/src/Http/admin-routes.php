<?php

use Organon\Delivery\Http\Controllers\Admin\DriverController;
use Organon\Delivery\Http\Controllers\Admin\PackageController;
use Organon\Delivery\Http\Controllers\Admin\TripController;
use Organon\Delivery\Http\Controllers\Admin\WarehouseAdminController;
use Organon\Delivery\Http\Controllers\Admin\WarehouseController;
use Organon\Delivery\Http\Controllers\Driver\AddPackageController as DriverAddPackageController;
use Organon\Delivery\Http\Controllers\Driver\DashboardController as DriverDashboardController;
use Organon\Delivery\Http\Controllers\Driver\SessionController as DriverSessionController;
use Organon\Delivery\Http\Controllers\Driver\TripController as DriverTripController;
use Organon\Delivery\Http\Controllers\Driver\ViewPackageController as DriverViewPackageController;
use Organon\Delivery\Http\Controllers\WarehouseAdmin\AddPackageController;
use Organon\Delivery\Http\Controllers\WarehouseAdmin\DashboardController;
use Organon\Delivery\Http\Controllers\WarehouseAdmin\SessionController;
use Organon\Delivery\Http\Controllers\WarehouseAdmin\ViewPackageController;

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

        Route::group(['prefix' => 'trips', 'as' => 'trips.'], function () {
            Route::get('', [TripController::class, 'index'])->name('index');
            Route::get('create-pickup', [TripController::class, 'createPickup'])->name('create.pickup');
            Route::get('create-shipping', [TripController::class, 'createShipping'])->name('create.shipping');
            Route::post('create', [TripController::class, 'store'])->name('store');
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
        Route::post('logout', [SessionController::class, 'destroy'])->name('session.destroy');
        Route::get('/', DashboardController::class)->name('dashboard');
        Route::get('/add-package', [AddPackageController::class, 'create'])->name('add-package.create');
        Route::post('/add-package', [AddPackageController::class, 'store'])->name('add-package.store');
        Route::get('/package/{hash}', ViewPackageController::class)->name('view-package');
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
        Route::post('logout', [DriverSessionController::class, 'destroy'])->name('session.destroy');

        Route::get('/', DriverDashboardController::class)->name('dashboard');
        Route::get('/add-package', [DriverAddPackageController::class, 'create'])->name('add-package.create');
        Route::post('/add-package', [DriverAddPackageController::class, 'store'])->name('add-package.store');
        Route::get('/package/{hash}', DriverViewPackageController::class)->name('view-package');

        Route::get('/trip/{id}', [DriverTripController::class, 'view'])->name('trip.view');
        Route::post('/trip/{id}/start', [DriverTripController::class, 'start'])->name('trip.start');
        Route::post('/trip/{id}/finish', [DriverTripController::class, 'finish'])->name('trip.finish');
    });
});
