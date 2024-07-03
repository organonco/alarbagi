<?php

use Organon\Marketplace\Http\Controllers\Admin\OfferController;

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
    Route::get('seller-invoices/{invoice_id}', [\Organon\Marketplace\Http\Controllers\Admin\SellerInvoiceController::class, 'view'])->name('admin.sales.sellers.invoice.view');
    Route::get('seller-invoices', [\Organon\Marketplace\Http\Controllers\Admin\SellerInvoiceController::class, 'index'])->name('admin.sales.sellers.invoice.index');
    Route::post('seller-invoices/{invoice_id}/send', [\Organon\Marketplace\Http\Controllers\Admin\SellerInvoiceController::class, 'sendToSeller'])->name('admin.sales.sellers.invoice.send');
    Route::post('seller-invoices/{invoice_id}', [\Organon\Marketplace\Http\Controllers\Admin\SellerInvoiceController::class, 'destroy'])->name('admin.sales.sellers.invoice.destroy');
    Route::post('seller-invoices/{invoice_id}/unsend', [\Organon\Marketplace\Http\Controllers\Admin\SellerInvoiceController::class, 'unsendToSeller'])->name('admin.sales.sellers.invoice.unsend');
    Route::post('seller-invoices/{invoice_id}/approve', [\Organon\Marketplace\Http\Controllers\Admin\SellerInvoiceController::class, 'approve'])->name('admin.sales.sellers.invoice.approve');
    Route::post('seller-invoices/{invoice_id}/issue', [\Organon\Marketplace\Http\Controllers\Admin\SellerInvoiceController::class, 'issue'])->name('admin.sales.sellers.invoice.issue');
    Route::post('seller-invoices/{invoice_id}/reject', [\Organon\Marketplace\Http\Controllers\Admin\SellerInvoiceController::class, 'reject'])->name('admin.sales.sellers.invoice.reject');
    Route::post('seller-invoices/{invoice_id}/item', [\Organon\Marketplace\Http\Controllers\Admin\SellerInvoiceController::class, 'addItem'])->name('admin.sales.sellers.invoice.add_item');
    Route::delete('seller-invoices/{invoice_id}/item/{item_id}', [\Organon\Marketplace\Http\Controllers\Admin\SellerInvoiceController::class, 'deleteItem'])->name('admin.sales.sellers.invoice.delete_item');


    Route::get('sellers', [\Organon\Marketplace\Http\Controllers\Admin\SellerController::class, 'index'])->name('admin.sales.sellers.index');
    Route::get('sellers/{seller_id}', [\Organon\Marketplace\Http\Controllers\Admin\SellerController::class, 'view'])->name('admin.sales.sellers.view');
    Route::post('sellers/{seller_id}/activate', [\Organon\Marketplace\Http\Controllers\Admin\SellerController::class, 'activate'])->name('admin.sales.sellers.activate');
    Route::post('sellers/{seller_id}/deactivate', [\Organon\Marketplace\Http\Controllers\Admin\SellerController::class, 'deactivate'])->name('admin.sales.sellers.deactivate');
    Route::post('sellers/{seller_id}/invoice', [\Organon\Marketplace\Http\Controllers\Admin\SellerInvoiceController::class, 'generate'])->name('admin.sales.sellers.invoice.generate');
    Route::post('sellers/{seller_id}/expiry', [\Organon\Marketplace\Http\Controllers\Admin\SellerController::class, 'updateExpiryDate'])->name('admin.sales.sellers.expiry');
});


Route::group([
    'prefix' => config('app.admin_url') . '/account',
    'middleware' => ['web', 'admin']
], function () {
    Route::get('profile', [\Organon\Marketplace\Http\Controllers\Admin\SellerAccountController::class, 'profile'])->name('admin.account.profile.view');
    Route::post('profile', [\Organon\Marketplace\Http\Controllers\Admin\SellerAccountController::class, 'updateProfile'])->name('admin.account.profile.update');
    Route::get('settings', [\Organon\Marketplace\Http\Controllers\Admin\SellerAccountController::class, 'settings'])->name('admin.account.settings.view');
    Route::post('settings\password', [\Organon\Marketplace\Http\Controllers\Admin\SellerAccountController::class, 'updatePassword'])->name('admin.account.settings.update-password');
    Route::post('settings\payment-method', [\Organon\Marketplace\Http\Controllers\Admin\SellerAccountController::class, 'updateSettings'])->name('admin.account.settings.update-settings');
    Route::post('settings\account-status', [\Organon\Marketplace\Http\Controllers\Admin\SellerAccountController::class, 'updateAccountStatus'])->name('admin.account.settings.update-account-status');
});


Route::group([
    'prefix' => config('app.admin_url') . '/offers',
    'middleware' => ['web', 'admin']
], function () {
    Route::get('/', [OfferController::class, 'index'])->name('admin.offers.index');
    Route::post('/create', [OfferController::class, 'store'])->name('admin.offers.store');
    Route::get('/create', [OfferController::class, 'create'])->name('admin.offers.create');
    Route::get('/edit/{id}', [OfferController::class, 'edit'])->name('admin.offers.edit');
    Route::post('/edit/{id}', [OfferController::class, 'update'])->name('admin.offers.update');
    Route::get('/preview/{id}', [OfferController::class, 'preview'])->name('admin.offers.preview');
});
