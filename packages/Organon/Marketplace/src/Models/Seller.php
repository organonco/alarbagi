<?php

namespace Organon\Marketplace\Models;

use Illuminate\Database\Eloquent\Model;
use Organon\Marketplace\Contracts\Seller as SellerContract;
use Organon\Marketplace\Enums\SellerStatusEnum;
use Organon\Marketplace\Traits\HasStatusTrait;
use Webkul\User\Models\AdminProxy;

class Seller extends Model implements SellerContract
{

    use HasStatusTrait;

    protected $fillable = [
        'name',
        'description',
        'address',
        'slug'
    ];

    public function admin()
    {
        return $this->hasOne(AdminProxy::modelClass());
    }

    public static function getStatusEnum(): string
    {
        return SellerStatusEnum::class;
    }

    protected static function getDefaultStatus()
    {
        return SellerStatusEnum::PENDING;
    }
}