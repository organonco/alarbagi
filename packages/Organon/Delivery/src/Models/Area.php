<?php

namespace Organon\Delivery\Models;

use Illuminate\Database\Eloquent\Model;
use Organon\Delivery\Contracts\Area as AreaContract;

class Area extends Model implements AreaContract
{
    protected $fillable = [
        'name',
        'is_active',
        'info'
    ];

    public function scopeIsActive($query)
    {
        return $query->where('is_active', true);
    }

    public function shippingCompany()
    {
        return $this->hasOne(ShippingCompany::class);
    }
}