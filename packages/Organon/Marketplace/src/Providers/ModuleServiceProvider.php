<?php

namespace Organon\Marketplace\Providers;

use Konekt\Concord\BaseModuleServiceProvider;

class ModuleServiceProvider extends BaseModuleServiceProvider
{
    protected $models = [
        \Organon\Marketplace\Models\Seller::class
    ];
}