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
        return $this->direction == "0";
    }
    public function isDropOff()
    {
        return !$this->isPickup();
    }
    public static function getStatusEnum(): string
    {
        return TripStatusEnum::class;
    }
    protected static function getDefaultStatus()
    {
        return TripStatusEnum::PENDING;
    }
    public function parts()
    {
        return $this->hasMany(TripPart::class);
    }
    public function scopeInProgress($query)
    {
        return $query->where('status', TripStatusEnum::IN_PROGRESS->value);
    }

    public function getType()
    {
        return $this->isPickup() ? "Pick Up" : "Shipping";
    }
}
