<?php

/**
 * Store front routes.
 */

use Organon\Marketplace\Models\Order;
use Organon\Wadili\Models\Address;
use Organon\Wadili\Models\Order as ModelsOrder;
use Webkul\Customer\Models\CustomerAddress;

Route::get('testt', function () {
    $response = Http::withHeaders([
        'Authorization-Key' => config('wadili.key')
    ])->acceptJson()->post('https://api.wadilydelivery.com/wadily/order/arbagi');
    dd($response->body());
});


require 'store-front-routes.php';

/**
 * Customer routes. All routes related to customer
 * in storefront will be placed here.
 */
require 'customer-routes.php';

/**
 * Checkout routes. All routes related to checkout like
 * cart, coupons, etc will be placed here.
 */
require 'checkout-routes.php';
