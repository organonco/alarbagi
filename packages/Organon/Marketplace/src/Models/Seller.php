<?php

namespace Organon\Marketplace\Models;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
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
    use HasStatusTrait;
    use HasFactory;
    use HasSlug;

    protected $fillable = [
        'name',
        'description',
        'address',
        'slug',
        'payment_method',
        'deliver_by'
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
        return $this->getFirstMediaUrl(self::LOGO_MEDIA_COLLECTION);
    }

    public function getCoverUrlAttribute()
    {
        return $this->getFirstMediaUrl(self::COVER_MEDIA_COLLECTION);
    }

    public function isActivatable()
    {
        return $this->status != SellerStatusEnum::ACTIVE;
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
}