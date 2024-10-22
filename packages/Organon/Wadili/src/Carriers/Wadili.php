<?php

namespace Organon\Wadili\Carriers;

use Webkul\Checkout\Facades\Cart;
use Webkul\Shipping\Carriers\AbstractShipping;
use Webkul\Checkout\Models\CartShippingRate;

class Wadili extends AbstractShipping
{
    /**
     * Shipping method code
     *
     * @var string
     */
    protected $code  = 'wadili';

    public function isAvailable()
    {
        return true;
    }

    public function isVisible()
	{
		$cart = Cart::getCart();
		$shippingAddress = $cart->shipping_address;
		return $shippingAddress->area->is_external;
	}

    public function getCartShippingRateObject() : CartShippingRate
    {
        $object = new CartShippingRate;

        $object->carrier = 'wadili';
        $object->carrier_title = '';
        $object->method = 'wadili_wadili';
        $object->method_title = $this->getConfigData('title');
        $object->method_description = $this->getConfigData('description');
        $object->method_icon = $this->getIcon();

        $object->price = 0;
        $object->base_price = 0;

        $object->is_available = $this->isAvailable();
        $object->is_visible =  $this->isVisible();
        
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