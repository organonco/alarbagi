<?php

namespace Organon\Delivery\Models;

use Illuminate\Database\Eloquent\Model;
use Organon\Delivery\Contracts\WarehouseAdmin as WarehouseAdminContract;

class WarehouseAdmin extends Model implements WarehouseAdminContract
{
    protected $fillable = [
        'name',
        'email',
        'phone',
        'password'
    ];
}
