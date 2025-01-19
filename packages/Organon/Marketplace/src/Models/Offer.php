<?php

namespace Organon\Marketplace\Models;

use Carbon\Carbon;
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
        'title', 'post', 'status', 'image_url', 'seller_id', 'seller_status', 'product_id'
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

    public function scopeIsActive($query)
    {
        return $query->where('status', true);
    }

    public function scopeIsNotExpired($query)
    {
        return $query->where('created_at', '>=', Carbon::now()->subDays(config('shop.offer_timeout'))->toDateTimeString());
    }

    public function product()
    {
        return $this->belongsTo(Product::class);
    }
    
}