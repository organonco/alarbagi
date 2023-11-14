<?php

namespace Organon\Marketplace\Models;

use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Product extends \Webkul\Product\Models\Product
{
    protected $fillable = [
        'type',
        'attribute_family_id',
        'sku',
        'parent_id',
        'seller_id'
    ];

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
     * @return BelongsTo
     */
    public function seller(): BelongsTo
    {
        return $this->belongsTo(SellerProxy::modelClass());
    }
}