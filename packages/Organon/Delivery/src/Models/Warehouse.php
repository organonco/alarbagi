<?php

namespace Organon\Delivery\Models;

use Illuminate\Database\Eloquent\Model;
use Organon\Delivery\Contracts\Warehouse as WarehouseContract;
use Organon\Delivery\Interfaces\PackageHolder;
use Organon\Delivery\Traits\HoldsPackages;
use Organon\Marketplace\Enums\SellerOrderStatusEnum;
use Organon\Marketplace\Models\Seller;

class Warehouse extends Model implements WarehouseContract, PackageHolder
{

    use HoldsPackages;

    protected $fillable = [
        'name',
        'seller_id',
        'address',
        'additional_info',
        'emirate',
        'warehouse_admin_id'
    ];

    public function seller()
    {
        return $this->belongsTo(Seller::class);
    }

    public function warehouseAdmin()
    {
        return $this->belongsTo(WarehouseAdmin::class);
    }

    public function isForSeller(): bool
    {
        return !is_null($this->seller_id);
    }

    public function scopeForSeller($query, $sellerId)
    {
        return $query->where('seller_id', $sellerId);
    }

    public function getName(): string
    {
        return $this->name;
    }
    public function getPhone(): string
    {
        return $this->warehouseAdmin->phone;
    }

    public function getType(): string
    {
        return 'warehouse';
    }

    public function scopeIsPending($query)
    {
        return $this->query()->whereHas("packages", function ($query) {
            return $query->isPending();
        }, '>', 0);
    }

    public function getPendingPackagesCountAttribute()
    {
        return $this->packages()->isPending()->count();
    }
}
