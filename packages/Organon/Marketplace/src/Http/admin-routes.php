<?php

Route::group([
    'prefix' => config('app.admin_url') . '/marketplace',
    'middleware' => ['web', 'admin'],
], function () {
    Route::get('orders', [\Organon\Marketplace\Http\Controllers\Admin\SellerOrderController::class, 'index'])->name('marketplace.admin.orders.index');
    Route::get('order/{order_id}', [\Organon\Marketplace\Http\Controllers\Admin\SellerOrderController::class, 'edit'])->name('marketplace.admin.orders.view');
    Route::post('order/{order_id}/approve', [\Organon\Marketplace\Http\Controllers\Admin\SellerOrderController::class, 'approve'])->name('marketplace.admin.orders.approve');
    Route::post('order/{order_id}/cancel', [\Organon\Marketplace\Http\Controllers\Admin\SellerOrderController::class, 'cancel'])->name('marketplace.admin.orders.cancel');
});


Route::group([
    'prefix' => config('app.admin_url') . '/sales',
    'middleware' => ['web', 'admin']
], function () {
    Route::get('sellers', [\Organon\Marketplace\Http\Controllers\Admin\SellerController::class, 'index'])->name('admin.sales.sellers.index');
});


Route::group([
    'prefix' => config('app.admin_url') . '/account',
    'middleware' => ['web', 'admin']
], function(){
    Route::get('profile', [\Organon\Marketplace\Http\Controllers\Admin\SellerAccountController::class, 'profile'])->name('admin.account.profile.view');
    Route::post('profile', [\Organon\Marketplace\Http\Controllers\Admin\SellerAccountController::class, 'updateProfile'])->name('admin.account.profile.update');
    Route::get('settings', [\Organon\Marketplace\Http\Controllers\Admin\SellerAccountController::class, 'settings'])->name('admin.account.settings.view');
    Route::post('settings\password', [\Organon\Marketplace\Http\Controllers\Admin\SellerAccountController::class, 'updatePassword'])->name('admin.account.settings.update-password');
    Route::post('settings\payment-method', [\Organon\Marketplace\Http\Controllers\Admin\SellerAccountController::class, 'updatePaymentMethod'])->name('admin.account.settings.update-payment-method');

});