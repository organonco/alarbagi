<?php

namespace Organon\Delivery\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Organon\Delivery\Contracts\ShippingCompany as ShippingCompanyContract;

class ShippingCompany extends Authenticatable implements ShippingCompanyContract
{
    protected $fillable = [
        'name',
        'is_active',
        'info',
        'username',
        'password',
        'area_id'
    ];

    public function scopeIsActive($query)
    {
        return $query->where('is_active', true);
    }

    public function area()
    {
        return $this->belongsTo(Area::class);
    }
}