<?php

namespace Organon\Marketplace\Models;

use Konekt\Concord\Proxies\ModelProxy;

class SellerOrderProxy extends ModelProxy
{
    public static function modelClass()
    {
        return SellerOrder::class;
    }
}