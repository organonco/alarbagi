<?php

namespace Organon\Pickup\Carriers;

use Config;
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


    public function getIcon()
    {
        return "icon-product";
    }
    /**
     * Returns rate for shipping method
     *
     * @return CartShippingRate|false
     */
    public function calculate()
    {
        if (! $this->isAvailable()) {
            return false;
        }

        $object = new CartShippingRate;

        $object->carrier = 'pickup';
        $object->carrier_title = $this->getConfigData('title');
        $object->method = 'pickup_pickup';
        $object->method_title = $this->getConfigData('title');
        $object->method_description = $this->getConfigData('description');
        $object->method_icon = $this->getIcon();

        $object->price = 0;
        $object->base_price = 0;

        /** @var Cart */
        $cart = Cart::getCart();

        return $object;
    }
}