<?php

namespace Organon\Wadili\Carriers;

use Illuminate\Support\Facades\Http;
use Organon\Wadili\Models\Order;
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

    public function isVisible()
	{
		$cart = Cart::getCart();
		$shippingAddress = $cart->shipping_address;
		return $shippingAddress->area? $shippingAddress->area->is_external : false;
	}

    public function getCartShippingRateObject() : CartShippingRate
    {
        $object = new CartShippingRate;

        $object->carrier = 'wadili';
        $object->carrier_title = '';
        $object->method = 'wadili_wadili';
        $object->method_title = $this->getConfigData('title');
        $object->method_icon = $this->getIcon();
        $object->is_visible =  $this->isVisible();

        $cart = Cart::getCart();

        if($cart->items->groupBy('product.seller_id')->count() > 1){
            $object->method_description = trans('shipping-company::app.messages.more-than-one-seller');
            $object->is_available = false;
        }else{
            $object->method_description = $this->getConfigData('description');
            $object->is_available = true;
            $wadiliOrder = Order::fromCart($cart);
            $response = Http::withHeaders([
                'Authorization-Key' => config('wadili.key'),
                'x-access-token' => config('wadili.token'),
                'Content-Type' => 'application/json',
                'Accept' => "*/*",
                'Accept-Encoding' => "gzip, deflate, br",
                'Accept-Language' => "*"
            ])->post('https://api.wadilydelivery.com/wadily/order/arbagi', $wadiliOrder->toArray());
            dd($response->body());
        }
        
        return $object;
    }


    /**
     * Returns rate for shipping method
     *
     * @return CartShippingRate|false
     */
    public function calculate()
    {
        return $this->getCartShippingRateObject();
    }
}