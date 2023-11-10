<?php

namespace Organon\Marketplace\Models;

use Illuminate\Database\Eloquent\Model;
use Organon\Marketplace\Contracts\Seller as SellerContract;

class Seller extends Model implements SellerContract
{
    protected $fillable = [
        'name',
        'description',
        'address'
    ];
}