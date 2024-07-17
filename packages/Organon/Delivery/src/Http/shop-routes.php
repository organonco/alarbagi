<?php

use Organon\Delivery\Http\Controllers\Shop\AreaController;

Route::group([
        'prefix'     => 'delivery',
        'middleware' => ['web', 'theme', 'locale', 'currency']
    ], function () {

});