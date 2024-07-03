<?php

namespace Organon\Marketplace\Models;

use Illuminate\Database\Eloquent\Model;
use Organon\Marketplace\Contracts\Offer as OfferContract;
use Organon\Marketplace\Traits\RelatedToSellerTrait;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

class Offer extends Model implements OfferContract, HasMedia
{
    const IMAGE_MEDIA_COLLECTION = "image";
    use InteractsWithMedia, RelatedToSellerTrait;

    protected $fillable = [
        'title', 'post', 'status', 'image_url', 'seller_id'
    ];
    

    public function clearImage()
    {
        $this->clearMediaCollection(self::IMAGE_MEDIA_COLLECTION);
        $this->update(['image_url' => null]);
    }

    public function setImage($key)
    {
        $this->clearImage();
        $this->addMediaFromRequest($key)->toMediaCollection(self::IMAGE_MEDIA_COLLECTION);
        $this->update(['image_url' => $this->generateImageUrl()]);
    }

    private function generateImageUrl()
    {
        return $this->getFirstMediaUrl(self::IMAGE_MEDIA_COLLECTION);
    }
    

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

    
}