<?php

use Organon\Wadili\Http\Controllers\WadiliController;

Route::post('wadili-hook', [WadiliController::class, 'hook']);