<?php

namespace Organon\Delivery\Models;

use Illuminate\Database\Eloquent\Model;
use Organon\Delivery\Contracts\TripPart as TripPartContract;

class TripPart extends Model implements TripPartContract
{
    protected $fillable = [];
}