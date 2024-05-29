<?php

namespace Organon\Marketplace\Traits;

use Organon\Delivery\Models\WarehouseAdmin;
use Organon\Marketplace\Models\Admin;
use Organon\Marketplace\Models\Seller;

trait InteractsWithAuthenticatedAdmin
{

    private function getAuthenticatedAdmin(): ?Admin
    {
        return auth('admin')->user();
    }

    private function getAuthenticatedSeller(): ?Seller
    {
        return $this->getAuthenticatedAdmin()?->getSeller();
    }

    private function isAuthenticatedAdminSeller(): bool
    {
        return !is_null($this->getAuthenticatedSeller());
    }

    private function getAuthenticatedWarehouseAdmin(): ?WarehouseAdmin
    {
        return auth('warehouse_admin')->user();
    }
}
