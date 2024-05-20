<?php

namespace Organon\Marketplace\Notifications\Repositories;

use Organon\Marketplace\Contracts\SellerOrder;
use Organon\Marketplace\Enums\SellerOrderStatusEnum;
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
     * @param $suborders
     * @return void
     */
    public function createMany($order, $suborders)
    {
        return $order->sellerOrders()->createMany($suborders);
    }


    /**
     * @param SellerOrder $sellerOrder
     * @return void
     */
    public function approve(SellerOrder $sellerOrder)
    {
        $sellerOrder->setStatus(SellerOrderStatusEnum::APPROVED);
    }

    /**
     * @param SellerOrder $sellerOrder
     * @return void
     */
    public function cancel(SellerOrder $sellerOrder)
    {
        $sellerOrder->setStatus(SellerOrderStatusEnum::CANCELLED_BY_SELLER);
    }


    /**
     * @param SellerOrder $sellerOrder
     * @return void
     */
    public function ready(SellerOrder $sellerOrder)
    {
        $sellerOrder->setStatus(SellerOrderStatusEnum::READY_FOR_PICKUP);
    }
}
