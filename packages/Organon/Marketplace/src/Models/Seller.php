<?php

namespace Organon\Marketplace\Models;

use Illuminate\Database\Eloquent\Model;
use Organon\Marketplace\Contracts\Seller as SellerContract;
use Organon\Marketplace\Enums\SellerStatusEnum;
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

    protected $fillable = [
        'name',
        'description',
        'address',
        'slug',
        'payment_method'
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
}