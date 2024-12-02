<?php

namespace Organon\Marketplace\Models;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Organon\Delivery\Models\Area;
use Organon\Marketplace\Contracts\Seller as SellerContract;
use Organon\Marketplace\Database\Factories\SellerFactory;
use Organon\Marketplace\Enums\SellerInvoiceStatusEnum;
use Organon\Marketplace\Enums\SellerStatusEnum;
use Organon\Marketplace\Traits\HasSlug;
use Organon\Marketplace\Traits\HasStatusTrait;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Webkul\User\Models\AdminProxy;

class Seller extends Model implements SellerContract, HasMedia
{
    const LOGO_MEDIA_COLLECTION = "logo";
    const COVER_MEDIA_COLLECTION = "cover";



    use InteractsWithMedia;
    use HasStatusTrait {
        setStatus as setStatusSuper;
    }
    use HasFactory;
    use HasSlug;

    protected $fillable = [
        'name',
        'address',
        'slug',
        'phone',
        'landline',
        'area_id',
        'seller_category_id',
        'token',
		'owner_name',
		'opening_time',
		'opening_days',
        'ref'
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

    public function setLogo($key)
    {
        $this->clearMediaCollection(self::LOGO_MEDIA_COLLECTION);
        $this->addMediaFromRequest($key)->toMediaCollection(self::LOGO_MEDIA_COLLECTION);
    }

    public function setCover($key)
    {
        $this->clearMediaCollection(self::COVER_MEDIA_COLLECTION);
        $this->addMediaFromRequest($key)->toMediaCollection(self::COVER_MEDIA_COLLECTION);
    }

    public function getLogoUrlAttribute()
    {
        return $this->getFirstMediaUrl(self::LOGO_MEDIA_COLLECTION) == "" ? asset('assets/images/icons/placeholder.png') : $this->getFirstMediaUrl(self::LOGO_MEDIA_COLLECTION);
    }

    public function getCoverUrlAttribute()
    {
        return $this->getFirstMediaUrl(self::COVER_MEDIA_COLLECTION);
    }

    public function isActivatable()
    {
        return $this->status == SellerStatusEnum::DEACTIVATED || $this->status == SellerStatusEnum::PENDING;
    }

    public function isDeactivatable()
    {
        return $this->status == SellerStatusEnum::ACTIVE;
    }

    public function isPauseable()
    {
        return $this->status == SellerStatusEnum::ACTIVE;
    }

    public function isUnpauseable()
    {
        return $this->status == SellerStatusEnum::PAUSED;
    }

    /**
     * Create a new factory instance for the model.
     *
     * @return \Illuminate\Database\Eloquent\Factories\Factory
     */
    protected static function newFactory(): Factory
    {
        return SellerFactory::new();
    }


    public function sellerOrders()
    {
        return $this->hasMany(SellerOrder::class);
    }


    public function invoices()
    {
        return $this->hasMany(SellerInvoice::class);
    }

    public function hasDraftInvoice()
    {
        return $this->invoices()->where('status', SellerInvoiceStatusEnum::DRAFT)->count() > 0;
    }

    public function getDraftInvoiceId()
    {
        return $this->invoices()->where('status', SellerInvoiceStatusEnum::DRAFT)->first()->id;
    }

    public function products()
    {
        return $this->hasMany(Product::class);
    }

    public function offers()
    {
        return $this->hasMany(Offer::class);
    }

    public function setStatus($status)
    {
        $this->setStatusSuper($status);
        $this->products()->withoutGlobalScope('seller_status')->update(['seller_status' => $status->value]);
        $this->offers()->withoutGlobalScope('seller_status')->update(['seller_status' => $status->value]);
    }

    public function area()
    {
        return $this->belongsTo(Area::class);
    }

    public function getAreaNameAttribute()
    {
        return $this->area->name;
    }

    public function getSellerCategoryNameAttribute()
    {
        return $this->sellerCategory->name;
    }

    public function scopeIsActive($query)
    {
        return $query->where('status', SellerStatusEnum::ACTIVE->value);
    }

    public function sellerCategory()
    {
        return $this->belongsTo(SellerCategory::class);
    }

    public function scopeSellerCategory($query, $id)
    {
        return $query->where('seller_category_id', $id);
    }

    public function scopeArea($query, $id)
    {
        return $query->where('area_id', $id);
    }
}
