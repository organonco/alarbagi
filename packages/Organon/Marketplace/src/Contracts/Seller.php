<?php

namespace Organon\Marketplace\Contracts;

interface Seller
{
    public static function bySlug(string $slug) : Seller;
}