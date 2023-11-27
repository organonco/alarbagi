<?php

Route::group([
    'prefix' => config('app.admin_url') . '/marketplace',
    'middleware' => ['web', 'admin']
], function () {
    Route::get('orders', [\Organon\Marketplace\Http\Controllers\Admin\SellerOrderController::class, 'index'])->defaults('_config', [
        'view' => 'marketplace::admin.orders.index',
    ])->name('marketplace.admin.orders.index');
    Route::get('order/{order_id}', [\Organon\Marketplace\Http\Controllers\Admin\SellerOrderController::class, 'edit'])->defaults('_config', [
        'view' => 'marketplace::admin.orders.view',
    ])->name('marketplace.admin.orders.view');
    Route::post('order/{order_id}/approve', [\Organon\Marketplace\Http\Controllers\Admin\SellerOrderController::class, 'approve'])->name('marketplace.admin.orders.approve');
    Route::post('order/{order_id}/cancel', [\Organon\Marketplace\Http\Controllers\Admin\SellerOrderController::class, 'cancel'])->name('marketplace.admin.orders.cancel');
});


Route::group([
    'prefix' => config('app.admin_url') . '/sales',
    'middleware' => ['web', 'admin']
], function () {
    Route::get('sellers', [\Organon\Marketplace\Http\Controllers\Admin\SellerController::class, 'index'])->name('admin.sales.sellers.index');
});
