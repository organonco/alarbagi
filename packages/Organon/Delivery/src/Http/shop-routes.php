<?php

Route::group([
    'prefix'     => 'delivery',
    'middleware' => ['web', 'theme', 'locale', 'currency']
], function () {
});
