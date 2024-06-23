<?php

namespace Organon\Marketplace\Models;

use Illuminate\Database\Eloquent\Model;
use Organon\Marketplace\Contracts\Offer as OfferContract;
use Spatie\MediaLibrary\InteractsWithMedia;

class Offer extends Model implements OfferContract
{
    const IMAGE_MEDIA_COLLECTION = "image";
    use InteractsWithMedia;

    protected $fillable = [
        'title', 'post'
    ];
    
    public function setImage($key)
    {
        $this->clearMediaCollection(self::IMAGE_MEDIA_COLLECTION);
        $this->addMediaFromRequest($key)->toMediaCollection(self::IMAGE_MEDIA_COLLECTION);
    }

    public function getImageUrlAttribute()
    {
        return $this->getFirstMediaUrl(self::IMAGE_MEDIA_COLLECTION);
    }
    
}