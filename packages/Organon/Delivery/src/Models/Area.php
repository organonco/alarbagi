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

    public $appends = [
        'is_shippable'
    ];

    public function scopeIsActive($query)
    {
        return $query->where('is_active', true);
    }

    public function shippingCompany()
    {
        return $this->hasOne(ShippingCompany::class);
    }

    public function getIsShippableAttribute()
    {
        return !is_null($this->shippingCompany) && $this->shippingCompany->is_active;
    }
}