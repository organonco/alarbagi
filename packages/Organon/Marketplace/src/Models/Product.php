<?php

namespace Organon\Marketplace\Models;

use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Organon\Marketplace\Traits\RelatedToSellerTrait;
use Webkul\Product\Database\Eloquent\Builder;

class Product extends \Webkul\Product\Models\Product
{
    use RelatedToSellerTrait;

    protected $fillable = [
        'type',
        'attribute_family_id',
        'sku',
        'parent_id',
        'seller_id'
    ];

    protected $appends = [
        'seller_name',
        'seller_slug'
    ];


    public function getStockQuantityAttribute()
    {
        $managed = $this->attribute_values()->where('attribute_id', '=', 28)->first();
        if($managed->boolean_value)
            return $this->inventories()->sum('qty');
        else return -1;
    }

    /**
     * @return int|null
     */
    public function getSellerId(): int|null
    {
        return $this->seller_id;
    }

    /**
     * @return bool
     */
    public function isForSeller(): bool
    {
        return !is_null($this->getSellerId());
    }

    /**
     * @return string|null
     */
    public function getSellerNameAttribute()
    {
        return $this->seller?->name;
    }

    /**
     * @return string|null
     */
    public function getSellerSlugAttribute()
    {
        return $this->seller?->slug;
    }

    /**
     * @return int
     */
    public function getSellerAreaId()
    {
        return $this->seller->area_id;
    }
}