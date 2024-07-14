<?php

namespace Organon\Pickup\Carriers;

use Webkul\Checkout\Facades\Cart;
use Webkul\Shipping\Carriers\AbstractShipping;
use Webkul\Checkout\Models\CartShippingRate;

class Pickup extends AbstractShipping
{
    /**
     * Shipping method code
     *
     * @var string
     */
    protected $code  = 'pickup';

    public function isAvailable()
    {
        //Always Available to pickup
        return true;
    }

    public function getCartShippingRateObject() : CartShippingRate
    {
        $object = new CartShippingRate;

        $object->carrier = 'pickup';
        $object->carrier_title = $this->getConfigData('title');
        $object->method = 'pickup_pickup';
        $object->method_title = $this->getConfigData('title');
        $object->method_description = $this->getConfigData('description');
        $object->method_icon = $this->getIcon();

        //Always Free to pickup
        $object->price = 0;
        $object->base_price = 0;

        $object->is_available = $this->isAvailable();
        
        return $object;
    }


    /**
     * Returns rate for shipping method
     *
     * @return CartShippingRate|false
     */
    public function calculate()
    {
        if (! $this->isAvailable())
            return false;
        return $this->getCartShippingRateObject();
    }
}