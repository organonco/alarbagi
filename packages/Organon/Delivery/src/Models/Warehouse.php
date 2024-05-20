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

    public function isForSeller()
    {
        return !is_null($this->seller_id);
    }

    public function scopeForSeller($query, $sellerId)
    {
        return $query->where('seller_id', $sellerId);
    }
}
