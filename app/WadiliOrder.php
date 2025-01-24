<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Hash;
use Organon\Marketplace\Models\Order;
use Webkul\Checkout\Models\Cart;

class WadiliOrder extends Model
{
    public $guarded = [];

    public function order()
    {
        return $this->belongsTo(Order::class);
    }

    public static function findForOrder($order_id) : self
    {
        return self::where('order_id', $order_id)->latest()->first();
    }

    public static function findForCart($cart_id, $hash) : ?self
    {
        return self::where('cart_id', $cart_id)->where('cart_hash', $hash)->latest()->first();
    }

    public static function findByWadiliOrderId(string $orderId)
    {
        return self::where('wadili_order_id', $orderId)->first();
    }

    public static function createFromWadiliResponse($response, Cart $cart)
    {
        return self::create([
            'success' => $response->success,
            'message' => $response->message->ar,
            'number' => $response->number,
            'service_fees' => $response->totalServiceFees,
            'distance' => $response->tripDistanceKm,
            'wadili_order_id' => $response->orderId,
            'payment_method' => $response->paymentMethod,
            'cart_id' => $cart->id,
            'cart_hash' => self::createCartHashFromCart($cart)
        ]);
    }

    public static function createCartHashFromCart($cart)
    {
        $recieverAddress = $cart->shipping_address;
        $seller = $cart->items()->first()->product->seller;
        return self::createCartHash($seller->lat, $seller->lng, $recieverAddress->lat, $recieverAddress->lng, $cart->sub_total);
    }

    public static function createCartHash($sLat, $sLng, $rLat, $rLng, $subTotal)
    {
        $subTotal = intval($subTotal);
        return hash('md5', "{$sLat}-{$sLng}-{$rLat}-{$rLng}-{$subTotal}");
    }
}