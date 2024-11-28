<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Organon\Marketplace\Models\Product;

class Variant extends Model
{
    public $fillable = ['label', 'price'];
    
    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}
