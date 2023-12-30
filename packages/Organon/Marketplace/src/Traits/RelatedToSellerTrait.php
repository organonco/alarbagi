<?php

namespace Organon\Marketplace\Traits;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Organon\Marketplace\Enums\SellerStatusEnum;
use Organon\Marketplace\Models\Seller;
use Organon\Marketplace\Models\SellerProxy;
use Webkul\Product\Database\Eloquent\Builder;

trait RelatedToSellerTrait
{
    public static function getStatusEnum(){
        return SellerStatusEnum::class;
    }

    /**
     * @return BelongsTo
     */
    public function seller(): BelongsTo
    {
        return $this->belongsTo(SellerProxy::modelClass());
    }


    protected function getDefaultStatus(){
        return $this->seller->status;
    }

    protected static function bootRelatedToSellerTrait()
    {
        static::addGlobalScope('seller_status', function(Builder $builder){
            $builder->where('products.seller_status', SellerStatusEnum::ACTIVE->value);
        });

        static::creating(function ($query) {
            $query->status = $this->getDefaultStatus();
        });
    }

    protected function sellerStatus(): Attribute
    {
        return Attribute::make(
            get: fn (string $value) => static::getStatusFromValue($value),
            set: fn ($value) => $this->set($value)
        );
    }


    public function setStatus($status)
    {
        $this->seller_status = $status;
        $this->save();
    }


    private function set($status)
    {
        return $status->value;
    }

    public static function getStatusFromValue($value)
    {
        return static::getStatusEnum()::from($value);
    }
}