<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Organon\Delivery\Contracts\Area;
use Organon\Marketplace\Contracts\SellerCategory;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

class Banner extends Model implements HasMedia
{
    use InteractsWithMedia;
    const BANNER_MEDIA_COLLECTION = 'banner';

    public $fillable = ['is_mobile', 'area_id', 'seller_category_id'];


    public function sellerCategory()
    {
        return $this->belognsTo(SellerCategory::class);
    }

    public function area()
    {
        return $this->belongsTo(Area::class);
    }

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

    public function scopeMain($query)
    {
        return $query->whereNull('area_id')->whereNull('seller_category_id');
    }

    public function scopeDesktop($query)
    {
        return $query->where('is_mobile', false);
    }

    public function scopeMobile($query)
    {
        return $query->where('is_mobile', true);
    }


    public static function transform($collection)
    {
        return [
            'images' => $collection->map(function (Banner $banner) {
                return [
                    'id' => $banner->id,
                    'image' => $banner->getBannerUrl(),
                ];
            })->toArray()
        ];
    }

    public function scopeForArea($query, $areaId)
    {
        return $query->where('area_id', $areaId);
    }

    public function scopeForSellerCategory($query, $areaId, $sellerCategoryId)
    {
        return $query->where('area_id', $areaId)->where('seller_category_id', $sellerCategoryId);
    }
}
