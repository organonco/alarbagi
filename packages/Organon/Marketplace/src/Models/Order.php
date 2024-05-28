<?php

namespace Organon\Marketplace\Models;

use Illuminate\Database\Eloquent\Relations\HasMany;
use Organon\Marketplace\Enums\SellerOrderStatusEnum;

class Order extends \Webkul\Sales\Models\Order
{
    /**
     * @return HasMany
     */
    public function sellerOrders(): HasMany
    {
        return $this->hasMany(SellerOrderProxy::modelClass());
    }

    public function canCancel(): bool
    {
        foreach($this->sellerOrders as $sellerOrder)
            if($sellerOrder->status == SellerOrderStatusEnum::APPROVED)
                return false;
        return parent::canCancel(); 
    }

    public function canShip(): bool
    {
        return false;
    }

    public function canInvoice(): bool
    {
        return false;
    }

    public function canRefund(): bool
    {
        return false;
    }
}