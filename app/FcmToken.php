<?php

namespace App;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Webkul\Customer\Models\Customer;

class FcmToken extends Model
{
    public $guarded = [];
    public $timestamps = false;
    
    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }
}
