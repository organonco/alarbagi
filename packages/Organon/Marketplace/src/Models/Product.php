<?php

namespace Organon\Marketplace\Models;

class Product extends \Webkul\Product\Models\Product
{
    protected $fillable = [
        'type',
        'attribute_family_id',
        'sku',
        'parent_id',
        'seller_id'
    ];
}