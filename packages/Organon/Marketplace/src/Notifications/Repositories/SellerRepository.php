<?php

namespace Organon\Marketplace\Notifications\Repositories;

use Organon\Marketplace\Enums\SellerStatusEnum;
use Organon\Marketplace\Models\Seller;
use Webkul\Core\Eloquent\Repository;

class SellerRepository extends Repository
{
    /**
     * Specify Model class name
     *
     * @return mixed
     */
    function model()
    {
        return 'Organon\Marketplace\Contracts\Seller';
    }



    public function activate($id)
    {
        $this->find($id)->setStatus(SellerStatusEnum::ACTIVE);
    }

    public function deactivate($id)
    {
        $this->find($id)->setStatus(SellerStatusEnum::DEACTIVATED);
    }

    public function findBySlug(string $slug): Seller
    {
        return Seller::bySlug($slug);
    }
}
