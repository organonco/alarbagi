<?php

namespace Organon\Delivery\Models;

use Illuminate\Database\Eloquent\Model;
use Organon\Delivery\Contracts\Area as AreaContract;
use Organon\Marketplace\Models\Seller;
use Organon\Marketplace\Traits\HasBanner;
use Organon\Marketplace\Traits\HasImage;
use Spatie\MediaLibrary\HasMedia;

class Area extends Model implements AreaContract, HasMedia
{
    use HasBanner, HasImage;

    protected $fillable = [
        'name',
        'is_active',
        'info'
    ];

    public $appends = [
        'is_shippable'
    ];

    public $hidden = [
        'created_at', 'updated_at', 'is_active'
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

    public function sellers()
    {
        return $this->hasMany(Seller::class);
    }
    
}