<?php

namespace Organon\Marketplace\Repositories;

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
}