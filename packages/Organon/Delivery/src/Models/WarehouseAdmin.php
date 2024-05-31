<?php

namespace Organon\Delivery\Models;

use Organon\Delivery\Contracts\WarehouseAdmin as WarehouseAdminContract;
use Organon\Marketplace\Models\Seller;
use Illuminate\Foundation\Auth\User as Authenticatable;

class WarehouseAdmin extends Authenticatable implements WarehouseAdminContract
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

    public function warehouse()
    {
        return $this->hasOne(Warehouse::class);
    }

    public function isForSeller()
    {
        return !is_null('sellerId');
    }

    public function scopeForSeller($query, $sellerId)
    {
        return $query->where('seller_id', $sellerId);
    }

    public function getPackages()
    {
        return $this->warehouse->packages;
    }

    public function getSeller(): Seller
    {
        return $this->seller;
    }

    public function getSellerId(): ?int
    {
        return $this->seller_id;
    }
}
