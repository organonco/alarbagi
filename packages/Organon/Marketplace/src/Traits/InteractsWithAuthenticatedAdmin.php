<?php

namespace Organon\Marketplace\Traits;


use Organon\Marketplace\Models\Admin;
use Organon\Marketplace\Models\Seller;

trait InteractsWithAuthenticatedAdmin
{

    private function getAuthenticatedAdmin() : ?Admin
    {
        return auth('admin')->user();
    }

    private function getAuthenticatedSeller(): ?Seller
    {
        return $this->getAuthenticatedAdmin()?->getSeller();
    }
}