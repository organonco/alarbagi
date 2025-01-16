<?php

namespace Organon\Marketplace\Models;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Organon\Marketplace\Contracts\SellerCategory as SellerCategoryContract;
use Organon\Marketplace\Traits\HasImage;
use Spatie\MediaLibrary\HasMedia;

class SellerCategory extends Model implements SellerCategoryContract, HasMedia
{
    use HasImage;

    protected $fillable = ['name', 'parent_id', 'sort', 'is_active'];

    public function scopeIsActive($query)
	{
		return $query->where('is_active', true);
	}

    public function isParent(): bool
    {
        return $this->children()->count() > 0;
    }

    public function parent()
    {
        return $this->belongsTo(self::class, 'parent_id');
    }

    public function getParent(): ?self
    {
        return $this->parent;
    }

    public function children()
    {
        return $this->hasMany(self::class, 'parent_id');
    }

    public function getChildren(): Collection
    {
        return $this->children->sortBy("sort");
    }

    public function scopeMain($query)
    {
        return $query->whereNull('parent_id');
    }

    public function scopeChild($query, $id)
    {
        return $query->where('parent_id', $id);
    }

    public function getImageUrl()
    {
        if ($this->getFirstMediaUrl(self::IMAGE_MEDIA_COLLECTION) == "")
            if ($this->parent?->getFirstMediaUrl(self::IMAGE_MEDIA_COLLECTION) == "")
                return asset('assets/images/icons/placeholder.png');
            else
                return $this->parent->getFirstMediaUrl(self::IMAGE_MEDIA_COLLECTION);
        else
            return $this->getFirstMediaUrl(self::IMAGE_MEDIA_COLLECTION);
    }
}
