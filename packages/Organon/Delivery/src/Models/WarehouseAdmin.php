<?php

namespace Organon\Delivery\Models;

use Illuminate\Database\Eloquent\Model;
use Organon\Delivery\Contracts\WarehouseAdmin as WarehouseAdminContract;
use Organon\Marketplace\Models\Seller;

class WarehouseAdmin extends Model implements WarehouseAdminContract
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

    public function warehouses()
    {
        return $this->belongsToMany(Warehouse::class);
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
