<?php

namespace Organon\Marketplace\Traits;

use Spatie\MediaLibrary\InteractsWithMedia;

trait HasImage
{
    use InteractsWithMedia;
    const IMAGE_MEDIA_COLLECTION = 'image';

    public function clearImage()
    {
        $this->clearMediaCollection(self::IMAGE_MEDIA_COLLECTION);
    }

    public function addImage($data)
    {
        if (isset($data['image'])) {
            $this->clearImage();
            $this->addMediaFromRequest('image')->toMediaCollection(self::IMAGE_MEDIA_COLLECTION);
        }
    }

    public function getImageUrl()
    {
        return $this->getFirstMediaUrl(self::IMAGE_MEDIA_COLLECTION);
    }

    public function getImageUrlAttribute()
    {
        return $this->getImageUrl();
    }

    public function updateImage($data)
    {
        if (isset($data['image'])) {
            if (!isset($data['image']['image']))
                $this->addImage($data);
        } else
            $this->clearImage();
    }
}
