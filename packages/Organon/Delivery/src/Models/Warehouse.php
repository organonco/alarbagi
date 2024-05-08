<?php

namespace Organon\Delivery\Models;

use Illuminate\Database\Eloquent\Model;
use Organon\Delivery\Contracts\Warehouse as WarehouseContract;
use Organon\Marketplace\Models\Seller;

class Warehouse extends Model implements WarehouseContract
{
    protected $fillable = [
        'name',
        'seller_id',
        'address',
        'additional_info',
        'emirate'
    ];

    public function seller()
    {
        return $this->belongsTo(Seller::class);
    }
}
