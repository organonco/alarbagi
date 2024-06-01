<?php

namespace Organon\Delivery\Models;

use Illuminate\Database\Eloquent\Model;
use Organon\Delivery\Contracts\Trip as TripContract;
use Organon\Delivery\Enums\TripStatusEnum;
use Organon\Marketplace\Traits\HasStatusTrait;

class Trip extends Model implements TripContract
{
    use HasStatusTrait;

    protected $fillable = ['driver_id', 'direction', 'status'];

    public function driver()
    {
        return $this->belongsTo(Driver::class);
    }
    public function isPickup()
    {
        return $this->direction;
    }
    public function isDropOff()
    {
        return !$this->direction;
    }
    public static function getStatusEnum(): string
    {
        return TripStatusEnum::class;
    }
    protected static function getDefaultStatus()
    {
        return TripStatusEnum::PENDING;
    }
}
