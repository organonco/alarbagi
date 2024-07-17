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

    public function addBanner($data)
    {
        if (isset($data['banner'])) {
            $this->clearBanner();
            $this->addMediaFromRequest('banner')->toMediaCollection(self::BANNER_MEDIA_COLLECTION);
        }
    }

    public function getBannerUrl()
    {
        return $this->getFirstMediaUrl(self::BANNER_MEDIA_COLLECTION);
    }

    public function getBannerUrlAttribute()
    {
        return $this->getBannerUrl();
    }

    public function updateBanner($data)
    {
        if (isset($data['banner'])) {
            if (!isset($data['banner']['image']))
                $this->addBanner($data);
        } else
            $this->clearBanner();
    }
}
