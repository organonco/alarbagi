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

        if ($cart->items->groupBy('product.seller_id')->count() > 1) {
            $object->method_description = trans('shipping-company::app.messages.more-than-one-seller');
            $object->is_available = false;
        } else {
            $object->method_description = $this->getConfigData('description');
            $object->is_available = true;
            $wadiliOrder = Order::fromCart($cart);

            $wadiliOrderModel = WadiliOrder::findForCart($cart->id, $cart->sub_total);

            if ($wadiliOrderModel == null) {
                $response = Http::withHeaders([
                    'Authorization-Key' => config('wadili.key'),
                    'x-access-token' => config('wadili.token'),
                    'Content-Type' => 'application/json',
                    'Accept' => "*/*",
                    'Accept-Encoding' => "gzip, deflate, br",
                    'Accept-Language' => "*"
                ])->post('https://api.wadilydelivery.com/wadily/order/arbagi', $wadiliOrder->toArray());
                $response = json_decode($response->body());
                $wadiliOrderModel = WadiliOrder::create([
                    'success' => $response->success,
                    'message' => $response->message->ar,
                    'number' => $response->number,
                    'service_fees' => $response->totalServiceFees,
                    'distance' => $response->tripDistanceKm,
                    'wadili_order_id' => $response->orderId,
                    'payment_method' => $response->paymentMethod,
                    'cart_id' => $cart->id,
                    'total' => $cart->sub_total
                ]);
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

        if($response->successful())
            $order->update(['status' => WadiliOrderStatus::UNREAD]);
        
        return $response;
    }
}
