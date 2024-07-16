<?php

namespace Organon\Delivery\Models;

use Illuminate\Database\Eloquent\Model;
use Organon\Delivery\Contracts\Driver as DriverContract;

class Driver extends Model implements DriverContract
{
    protected $fillable = [
        'name', 
        'phone', 
        'info',
        'shipping_company_id'
    ];

    
}