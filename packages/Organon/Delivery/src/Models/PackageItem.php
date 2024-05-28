<?php

namespace Organon\Delivery\Models;

use Illuminate\Database\Eloquent\Model;
use Organon\Delivery\Contracts\PackageItem as PackageItemContract;

class PackageItem extends Model implements PackageItemContract
{
    public $timestamps = false;
    protected $fillable = [
        'package_id',
        'order_item_id'
    ];
}
