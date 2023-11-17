<?php

namespace Organon\Marketplace\Models;

use Illuminate\Database\Eloquent\Model;
use Organon\Marketplace\Contracts\SellerOrder as SellerOrderContract;

class SellerOrder extends Model implements SellerOrderContract
{
    protected $fillable = [
        'order_id',
        'seller_id'
    ];
}