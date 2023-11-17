<?php

namespace Organon\Marketplace\Repositories;

use Webkul\Core\Eloquent\Repository;

class SellerOrderRepository extends Repository
{
    /**
     * Specify Model class name
     *
     * @return mixed
     */
    function model()
    {
        return 'Organon\Marketplace\Contracts\SellerOrder';
    }


    /**
     * @param $order
     * @param $sellerIds
     * @return void
     */
    public function createMany($order, $sellerIds)
    {
        return $order->sellerOrders()->createMany($sellerIds);
    }
}