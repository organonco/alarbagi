<?php

namespace Organon\Delivery\Models;

use Organon\Delivery\Contracts\Driver as DriverContract;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Organon\Delivery\Enums\TripStatusEnum;
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

    public function isForSeller(): bool
    {
        return false;
    }
    public function trips()
    {
        return $this->hasMany(Trip::class);
    }
    public function scopeIsAvailable($query)
    {
        return $query->whereHas("trips", function ($query) {
            return $query->where('status', '!=', TripStatusEnum::DONE->value);
        }, '=', 0);
    }
}
