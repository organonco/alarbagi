<?php

Route::group([
        'prefix'        => 'admin/marketplace',
        'middleware'    => ['web', 'admin']
    ], function () {

});