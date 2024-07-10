<?php

namespace Organon\Marketplace\Traits;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Organon\Marketplace\Enums\SellerStatusEnum;
use Organon\Marketplace\Models\SellerProxy;

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
        if($this->isForSeller())
            return $this->seller->status;
        else
            return SellerStatusEnum::ACTIVE;
    }

    protected static function bootRelatedToSellerTrait()
    {
        static::addGlobalScope('seller_status', function($builder){
            $builder->where('products.seller_status', SellerStatusEnum::ACTIVE->value);
        });

        static::creating(function ($item) {
            $item->seller_status = $item->getDefaultStatus();
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

    public function scopeForSeller($query, ?int $id)
    {
        if(is_null($id))
            return $query;
        return $query->where('seller_id', $id);
    }
}
