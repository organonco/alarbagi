<?php

namespace Organon\Marketplace\Models;

use Illuminate\Database\Eloquent\Model;
use Organon\Marketplace\Contracts\SellerOrder as SellerOrderContract;
use Organon\Marketplace\Enums\SellerOrderStatusEnum;
use Organon\Marketplace\Traits\HasStatusTrait;
use Webkul\Sales\Models\OrderProxy;

class SellerOrder extends Model implements SellerOrderContract
{
    use HasStatusTrait;

    protected $fillable = [
        'order_id',
        'seller_id',
        'subtotal',
        'number_of_products'
    ];

    public static function getStatusEnum(): string
    {
        return SellerOrderStatusEnum::class;
    }

    protected static function getDefaultStatus()
    {
        return SellerOrderStatusEnum::PENDING;
    }

    public function order()
    {
        return $this->belongsTo(OrderProxy::modelClass());
    }

    public function seller()
    {
        return $this->belongsTo(SellerProxy::modelClass());
    }
}