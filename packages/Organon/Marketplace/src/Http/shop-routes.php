<?php

Route::group([
    'prefix' => 'marketplace',
    'middleware' => ['web', 'theme', 'locale', 'currency']
], function () {
    Route::post('/register', [Organon\Marketplace\Http\Controllers\Shop\SellerController::class, 'store'])->name('shop.marketplace.register');
    Route::get('/register/{token}', [Organon\Marketplace\Http\Controllers\Shop\SellerController::class, 'verifyEmail'])->name('shop.marketplace.verify-email');
    Route::get('/shop/by-ref/{ref}', [\Organon\Marketplace\Http\Controllers\Shop\SellerController::class, 'showByRef'])->name('shop.marketplace.show-by-ref');
    Route::get('/shop/{slug}', [\Organon\Marketplace\Http\Controllers\Shop\SellerController::class, 'show'])->name('shop.marketplace.show');
});
