<?php

namespace Organon\Marketplace\Models;

use Illuminate\Database\Eloquent\Relations\HasMany;

class Order extends \Webkul\Sales\Models\Order
{
    /**
     * @return HasMany
     */
    public function sellerOrders(): HasMany
    {
        return $this->hasMany(SellerOrderProxy::modelClass());
    }
}