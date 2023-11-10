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
}