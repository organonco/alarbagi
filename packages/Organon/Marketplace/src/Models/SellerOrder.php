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
        'tax_amount',
        'grand_total',
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

    public function items()
    {
        return $this->order->items()->whereHas('product', function($query){
            return $query->where('seller_id', $this->seller_id);
        });
    }

    public function payment()
    {
        return $this->order->payment();
    }

    public function getIncrementIdAttribute()
    {
        return $this->order->increment_id;
    }

    public function getCustomerEmailAttribute()
    {
        return $this->order->customer_email;
    }

    public function getCustomerFullNameAttribute()
    {
        return $this->order->customer_full_name;
    }

    public function isApprovable()
    {
        return $this->status != SellerOrderStatusEnum::APPROVED;
    }

    public function isCancellable()
    {
        return $this->status != SellerOrderStatusEnum::CANCELLED_BY_SELLER;
    }

}
