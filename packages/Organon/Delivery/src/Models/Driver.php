<?php

namespace Organon\Delivery\Models;

use Organon\Delivery\Contracts\Driver as DriverContract;
use Organon\Marketplace\Models\Seller;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Organon\Delivery\Interfaces\PackageHolder;
use Organon\Delivery\Traits\HoldsPackages;

class Driver extends Authenticatable implements DriverContract, PackageHolder
{
    use HoldsPackages;

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

    public function getName(): string
    {
        return $this->name;
    }

    public function getPhone(): string
    {
        return $this->phone;
    }

    public function getType(): string
    {
        return 'driver';
    }
}
