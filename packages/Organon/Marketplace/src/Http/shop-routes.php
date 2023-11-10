<?php

Route::group([
    'prefix' => 'marketplace',
    'middleware' => ['web', 'theme', 'locale', 'currency']
], function () {

    Route::get('/', 'Organon\Marketplace\Http\Controllers\Shop\MarketplaceController@index')->defaults('_config', [
        'view' => 'marketplace::shop.index',
    ])->name('shop.marketplace.index');

    Route::post('/register', 'Organon\Marketplace\Http\Controllers\Shop\SellerController@store')->name('shop.marketplace.register');

});