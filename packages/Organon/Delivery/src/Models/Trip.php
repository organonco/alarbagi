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

    public function getStatusString()
    {
        if ($this->isPending()) return '<span class="text-yellow-300"> Pending </span>';
        if ($this->isInProgress()) return '<span class="text-blue-300"> In Progress </span>';
        if ($this->isDone()) return '<span class="text-green-300"> Done </span>';
        return "";
    }

    public function isPending()
    {
        return $this->status == TripStatusEnum::PENDING;
    }

    public function isInProgress()
    {
        return $this->status == TripStatusEnum::IN_PROGRESS;
    }

    public function isDone()
    {
        return $this->status == TripStatusEnum::DONE;
    }
}
