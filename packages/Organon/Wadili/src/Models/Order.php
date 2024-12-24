<?php

namespace Organon\Wadili\Models;

use Organon\Wadili\Enums\FeesPayBy;
use Organon\Wadili\Enums\PaymentMethod;
use Webkul\Checkout\Models\Cart;

class Order
{
    public function __construct(
        private String $password,
        private String $serviceId,
        private Address $senderAddress,
        private Address $receiverAddress,
        private FeesPayBy $deliveryFeesPayBy,
        private PaymentMethod $paymentMethod,
        private int $itemPrice,
    ) {}

    public function toArray()
    {
        return [
            'password' => $this->password,
            'serviceId' => $this->serviceId,
            'senderAddress' => $this->senderAddress->toArray(),
            'receiverAddress' => $this->receiverAddress->toArray(),
            'deliveryFeesPayBy' => $this->deliveryFeesPayBy->value,
            'paymentMethod' => $this->paymentMethod->value,
            'itemPrice' => $this->itemPrice,
        ];
    }




    public static function fromCart(Cart $cart)
    {
        $seller = $cart->items()->first()->product->seller;
        return new self(
            config('wadili.password'),
            config('wadili.service_id.bike'),
            Address::fromSeller($seller),
            Address::fromAddress($cart->shipping_address),
            FeesPayBy::Receiver,
            PaymentMethod::Cash,
            $cart->sub_total,
        );
    }
}
