<?php

namespace Organon\Marketplace\Models;

class Admin extends \Webkul\User\Models\Admin
{
    protected $fillable = [
        'name',
        'email',
        'password',
        'image',
        'api_token',
        'role_id',
        'status',
        'seller_id'
    ];

    protected $hidden = [
        'password',
        'api_token',
        'remember_token',
        'seller_id'
    ];


    public function isSeller()
    {
        return !is_null($this->seller_id);
    }

    public function seller()
    {
        return $this->belongsTo(SellerProxy::modelClass());
    }

    public function getSellerId()
    {
        return $this->seller_id;
    }

    /**
     * @return Seller
     */
    public function getSeller(): Seller
    {
        return $this->seller;
    }
}