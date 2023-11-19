<?php

Route::group([
    'prefix' => config('app.admin_url') . '/marketplace',
    'middleware' => ['web', 'admin']
], function () {
    Route::get('orders', [\Organon\Marketplace\Http\Controllers\Admin\SellerOrderController::class, 'index'])->defaults('_config', [
        'view' => 'marketplace::admin.orders.index',
    ])->name('marketplace.admin.orders.index');
});