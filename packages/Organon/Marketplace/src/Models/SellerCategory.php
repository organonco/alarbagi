<?php

namespace Organon\Marketplace\Models;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Organon\Marketplace\Contracts\SellerCategory as SellerCategoryContract;
use Organon\Marketplace\Traits\HasBanner;
use Organon\Marketplace\Traits\HasImage;
use Spatie\MediaLibrary\HasMedia;

class SellerCategory extends Model implements SellerCategoryContract, HasMedia
{
    use HasBanner, HasImage;

    protected $fillable = ['name', 'parent_id'];
    
    public function isParent() : bool
    {
        return is_null($this->parent_id);
    }

    public function parent() 
    {
        return $this->belongsTo(self::class, 'parent_id');
    }

    public function getParent() : ?self
    {
        return $this->parent;
    }

    public function children()
    {
        return $this->hasMany(self::class, 'parent_id');
    }

    public function getChildren() : Collection
    {
        return $this->children;
    }

    public function scopeMain($query)
    {
        return $query->whereNull('parent_id');
    }

    public function scopeChild($query, $id)
    {
        return $query->where('parent_id', $id);
    }
}