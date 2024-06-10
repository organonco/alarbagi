<?php

namespace Organon\Marketplace\Traits;
use Illuminate\Support\Str;

trait HasSlug
{
    public static function bySlug(string $slug): self
    {
        return self::query()->where('slug', $slug)->first();
    }

    public static function bootHasSlug()
    {
        static::creating(function ($query) {
            $slug = Str::slug($query->name);
            $query->slug = $slug;
            $count = self::where('slug', $slug)->count();
            if($count > 0)
                $query->slug = $query->slug . '-' . $count;
        });
    }
}