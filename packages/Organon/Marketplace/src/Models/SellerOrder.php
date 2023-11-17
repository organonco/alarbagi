<?php

namespace Organon\Marketplace\Models;

use Illuminate\Database\Eloquent\Model;
use Organon\Marketplace\Contracts\SellerOrder as SellerOrderContract;
use Organon\Marketplace\Enums\SellerOrderStatusEnum;
use Organon\Marketplace\Traits\HasStatusTrait;

class SellerOrder extends Model implements SellerOrderContract
{
    use HasStatusTrait;

    protected $fillable = [
        'order_id',
        'seller_id'
    ];

    public static function getStatusEnum(): string
    {
        return SellerOrderStatusEnum::class;
    }

    protected static function getDefaultStatus()
    {
        return SellerOrderStatusEnum::PENDING;
    }
}