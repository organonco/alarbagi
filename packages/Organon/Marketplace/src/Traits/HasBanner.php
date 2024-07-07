<?php

namespace Organon\Marketplace\Traits;

use Spatie\MediaLibrary\InteractsWithMedia;

trait HasBanner
{
    use InteractsWithMedia;
    const BANNER_MEDIA_COLLECTION = 'banner';

    public function clearBanner()
    {
        $this->clearMediaCollection(self::BANNER_MEDIA_COLLECTION);
    }

    public function addBanner($key)
    {
        $this->clearBanner();
        $this->addMediaFromRequest($key)->toMediaCollection(self::BANNER_MEDIA_COLLECTION);
    }

    public function getBannerUrl()
    {
        return $this->getFirstMediaUrl(self::BANNER_MEDIA_COLLECTION);
    }

    public function getBannerUrlAttribute()
    {
        return $this->getBannerUrl();
    }
}