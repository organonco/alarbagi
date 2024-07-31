<?php

namespace Organon\ShippingCompany\Carriers;

use Config;
use Webkul\Checkout\Facades\Cart;
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

    /**
     * @param int $price
     * @return CartShippingRate
     */
    private function getCartShippingRateObject(): CartShippingRate
    {
        $object = new CartShippingRate;

        $object->carrier = 'shippingcompany';
        $object->carrier_title = '';
        $object->method = 'shippingcompany_shippingcompany';
        $object->method_title = $this->getConfigData('title');
        $object->method_icon = $this->getIcon();

        return $object;
    }

    private function generateUnavailableObject(string $key)
    {
        return [
            'isAvailable' => false,
            'reason' => trans('shipping-company::app.messages.' . $key)
        ];
    }

    private function checkAvailability()
    {
        $cart = Cart::getCart();
        $shippingAddress = $cart->shipping_address;

        if (!$cart->hasDeliverableItems())
            return $this->generateUnavailableObject('no-deliverable-items');
        if (is_null($shippingAddress->area_id) || is_null($shippingAddress->address_details))
            return $this->generateUnavailableObject('address-or-area-not-found');
        if (!$shippingAddress->area->is_shippable)
            return $this->generateUnavailableObject('delivery-not-available-to-this-area');;

        return [
            'isAvailable' => true,
            'sameArea' => $this->sameArea($cart->shipping_address->area_id, $cart)
        ];
    }


    private function sameArea(int $areaId, $cart)
    {
        foreach ($cart->items as $item)
            if ($item->product->getSellerAreaId() != $areaId)
                return false;
        return true;
    }


    private function getShippingPrice(): int
    {
        $cart = Cart::getCart();
        $company = $cart->shipping_address->area->shippingCompany;
        $price = $company['per_order_price'];
        foreach ($cart->items as $item) {
            $price += $item->quantity * $company['per_product_price'];
        }
        return $price;
    }

    /**
     * @return CartShippingRate|false
     */
    public function calculate()
    {
        $object = $this->getCartShippingRateObject();
        $availability = $this->checkAvailability();

        $object->is_available = $availability['isAvailable'];

        if ($object->is_available && $availability['sameArea']) {
                $price = $this->getShippingPrice();
                $object->price = $price;
                $object->base_price = $price;
                $object->method_description = $this->getConfigData('description');
        } elseif($object->is_available) {
            $price = 0;
            $object->price = $price;
            $object->base_price = $price;
            $object->method_description = trans('shipping-company::app.messages.price-defined-later');
        } else {
            $object->method_description = $availability['reason'];
        }

        return $object;
    }
}
