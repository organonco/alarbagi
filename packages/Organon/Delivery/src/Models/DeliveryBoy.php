<?php

namespace Organon\Delivery\Models;

use Illuminate\Database\Eloquent\Model;
use Organon\Delivery\Contracts\DeliveryBoy as DeliveryBoyContract;
use Organon\Marketplace\Models\Seller;

class DeliveryBoy extends Model implements DeliveryBoyContract
{
    protected $fillable = [
        'name',
        'email',
        'phone',
        'password',
        'seller_id'
    ];

    public function seller()
    {
        return $this->belongsTo(Seller::class);
    }

    public function isForSeller()
    {
        return !is_null('sellerId');
    }

    public function getSelectedWarehousesIdsAttribute()
    {
        return $this->warehouses()->pluck('warehouses.id')->toArray();
    }
}
