<?php

namespace Organon\Delivery\Models;

use Illuminate\Database\Eloquent\Model;
use Organon\Delivery\Contracts\TripPart as TripPartContract;

class TripPart extends Model implements TripPartContract
{
    protected $fillable = ['direction', 'part_type', 'part_id', 'trip_id'];

    public function trip()
    {
        return $this->belongsTo(Trip::class);
    }

    public function part()
    {
        return $this->morphTo('part');
    }
}
