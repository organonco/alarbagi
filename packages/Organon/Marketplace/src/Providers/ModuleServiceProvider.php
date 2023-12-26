<?php

namespace Organon\Marketplace\Providers;

use Konekt\Concord\BaseModuleServiceProvider;

class ModuleServiceProvider extends BaseModuleServiceProvider
{
    protected $models = [
        \Organon\Marketplace\Models\Seller::class,
        \Organon\Marketplace\Models\SellerOrder::class,
        \Organon\Marketplace\Models\SellerInvoice::class,
        \Organon\Marketplace\Models\SellerInvoiceItem::class,
    ];
}