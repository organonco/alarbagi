<?php

namespace Organon\Wadili\Carriers;

use App\WadiliOrder;
use Illuminate\Support\Facades\Http;
use Organon\Wadili\Enums\WadiliOrderStatus;
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
        return $shippingAddress->area ? $shippingAddress->area->is_external : false;
    }


    private static function hasValue($value)
    {
        return !is_null($value) && !($value == "");
    }

    private static function addressIsvalid($address)
    {
        $values = [$address->lat, $address->lng, $address->street, $address->building, $address->floor, $address->area_id, $address->address_details];
        foreach ($values as $value)
            if (!self::hasValue($value))
                return false;
        return true;
    }

    public function getCartShippingRateObject(): CartShippingRate
    {
        $object = new CartShippingRate;

        $object->carrier = 'wadili';
        $object->carrier_title = '';
        $object->method = 'wadili_wadili';
        $object->method_title = $this->getConfigData('title');
        $object->method_icon = $this->getIcon();
        $object->is_visible =  $this->isVisible();

        $cart = Cart::getCart();

        $shippingAddress = $cart->shipping_address;

        if (!self::addressIsvalid($shippingAddress)) {
            $object->method_description = trans('shipping-company::app.messages.address-or-area-not-found');
            $object->is_available = false;
        } elseif ($cart->items->groupBy('product.seller_id')->count() > 1) {
            $object->method_description = trans('shipping-company::app.messages.more-than-one-seller');
            $object->is_available = false;
        } else {

            $object->method_description = $this->getConfigData('description');
            $object->is_available = true;
            $wadiliOrder = Order::fromCart($cart);

            $wadiliOrderModel = WadiliOrder::findForCart($cart->id, WadiliOrder::createCartHashFromCart($cart));

            if ($wadiliOrderModel == null) {
                $response = self::callCreateOrderAPI($wadiliOrder);
                $wadiliOrderModel = WadiliOrder::createFromWadiliResponse($response, $cart);
            }

            $object->price = $wadiliOrderModel->service_fees;
            $object->base_price = $wadiliOrderModel->service_fees;
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

    public static function callCreateOrderAPI(Order $order)
    {
        $response = Http::withHeaders([
            'Authorization-Key' => config('wadili.key'),
            'x-access-token' => config('wadili.token'),
            'Content-Type' => 'application/json',
            'Accept' => "*/*",
            'Accept-Encoding' => "gzip, deflate, br",
            'Accept-Language' => "*"
        ])->post('https://api.wadilydelivery.com/wadily/order/arbagi', $order->toArray());
        return json_decode($response->body());
    }

    public static function confirmOrder(WadiliOrder $order)
    {
        $orderId = $order->wadili_order_id;

        $response = Http::withHeaders([
            'Authorization-Key' => config('wadili.key'),
            'x-access-token' => config('wadili.token'),
            'Content-Type' => 'application/json',
            'Accept' => "*/*",
            'Accept-Encoding' => "gzip, deflate, br",
            'Accept-Language' => "*"
        ])->patch('https://api.wadilydelivery.com/wadily/order/confirm/arbagi', [
            'password' => config('wadili.password'),
            'orderId' => $orderId
        ]);

        if ($response->successful())
            $order->update(['status' => WadiliOrderStatus::UNREAD]);

        return $response;
    }
}
