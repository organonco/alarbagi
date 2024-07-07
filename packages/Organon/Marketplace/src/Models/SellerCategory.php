<?php

namespace Organon\Marketplace\Models;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Organon\Marketplace\Contracts\SellerCategory as SellerCategoryContract;

class SellerCategory extends Model implements SellerCategoryContract
{
    protected $fillable = ['name', 'parent_id'];
    public function hasParent() : bool
    {
        return is_null($this->parent_id);
    }

    public function parent() 
    {
        return $this->belongsTo(self::class);
    }

    public function getParent() : ?self
    {
        return $this->parent;
    }

    public function children()
    {
        return $this->hasMany(self::class);
    }

    public function getChildren() : Collection
    {
        return $this->children;
    }
}