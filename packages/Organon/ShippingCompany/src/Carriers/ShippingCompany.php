<?php

namespace Organon\ShippingCompany\Carriers;

use Config;
use Webkul\Shipping\Carriers\AbstractShipping;
use Webkul\Checkout\Models\CartShippingRate;
use Webkul\Shipping\Facades\Shipping;

class ShippingCompany extends AbstractShipping
{
    /**
     * Shipping method code
     *
     * @var string
     */
    protected $code  = 'shippingcompany';

    public function getIcon()
    {
        return "icon-flate-rate";
    }

    /** 
     * @return bool 
     */
    public function isAvailable() : bool
    {
        return true;
    }

    /**
     * @param int $price
     * @return CartShippingRate
     */
    public function getCartShippingRateObject(int $price) : CartShippingRate
    {
        $object = new CartShippingRate;

        $object->carrier = 'shippingcompany';
        $object->carrier_title = $this->getConfigData('title');
        $object->method = 'shippingcompany_shippingcompany';
        $object->method_title = $this->getConfigData('title');
        $object->method_description = $this->getConfigData('description');
        $object->method_icon = $this->getIcon();

        $object->price = $price;
        $object->base_price = $price;
        
        return $object;
    }



    /**
     * @return CartShippingRate|false
     */
    public function calculate()
    {
        if (! $this->isAvailable())
            return false;

        // Math Here Bla Bla Bla
        $price = 123;
        return $this->getCartShippingRateObject($price);
    }

}