<?php

namespace Organon\Marketplace\Models;

use Illuminate\Database\Eloquent\Model;
use Organon\Marketplace\Contracts\Seller as SellerContract;
use Webkul\User\Models\AdminProxy;

class Seller extends Model implements SellerContract
{
    protected $fillable = [
        'name',
        'description',
        'address'
    ];

    public function admin()
    {
        return $this->hasOne(AdminProxy::modelClass());
    }
}