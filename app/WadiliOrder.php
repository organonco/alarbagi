<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Organon\Marketplace\Models\Order;

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

    public static function findForCart($cart_id, $total) : ?self
    {
        return self::where('cart_id', $cart_id)->where('total', $total)->latest()->first();
    }

    public static function findByWadiliOrderId(string $orderId)
    {
        return self::where('wadili_order_id', $orderId)->first();
    }
}
