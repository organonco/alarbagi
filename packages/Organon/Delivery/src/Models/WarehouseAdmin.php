<?php

namespace Organon\Delivery\Models;

use Organon\Delivery\Contracts\WarehouseAdmin as WarehouseAdminContract;
use Organon\Marketplace\Models\Seller;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Organon\Marketplace\Traits\RelatedToSellerTrait;

class WarehouseAdmin extends Authenticatable implements WarehouseAdminContract
{

    use RelatedToSellerTrait;

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
