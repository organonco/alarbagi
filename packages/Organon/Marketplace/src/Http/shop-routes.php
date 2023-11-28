<?php

Route::group([
    'prefix' => 'marketplace',
    'middleware' => ['web', 'theme', 'locale', 'currency']
], function () {
    Route::post('/register', [Organon\Marketplace\Http\Controllers\Shop\SellerController::class, 'store'])->name('shop.marketplace.register');
});