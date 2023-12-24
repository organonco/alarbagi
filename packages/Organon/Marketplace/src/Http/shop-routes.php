<?php

Route::group([
    'prefix' => 'marketplace',
    'middleware' => ['web', 'theme', 'locale', 'currency']
], function () {
    Route::post('/register', [Organon\Marketplace\Http\Controllers\Shop\SellerController::class, 'store'])->name('shop.marketplace.register');
    Route::get('/shop/{slug}', [\Organon\Marketplace\Http\Controllers\Shop\SellerController::class, 'show'])->name('shop.marketplace.show');
});