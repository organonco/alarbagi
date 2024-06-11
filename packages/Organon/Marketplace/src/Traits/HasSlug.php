<?php

namespace Organon\Marketplace\Traits;

trait HasSlug
{
    public static function bySlug(string $slug): self
    {
        return self::query()->where('slug', $slug)->first();
    }
}