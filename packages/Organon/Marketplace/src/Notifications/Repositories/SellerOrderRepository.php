<?php

namespace Organon\Marketplace\Notifications\Repositories;

use Organon\Marketplace\Contracts\SellerOrder;
use Organon\Marketplace\Enums\SellerOrderStatusEnum;
use Organon\Marketplace\Models\Order;
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
        $sellerOrder->order->update(['status' => Order::STATUS_PROCESSING]);
    }

    /**
     * @param SellerOrder $sellerOrder
     * @return void
     */
    public function cancel(SellerOrder $sellerOrder)
    {
        $sellerOrder->setStatus(SellerOrderStatusEnum::CANCELLED_BY_SELLER);
        $cancelledCount = 0;
        $allCount = $sellerOrder->order->sellerOrders()->count();



        $count = 0;
        $allCount = $sellerOrder->order->sellerOrders()->count();
        foreach ($sellerOrder->order->sellerOrders as $sellerOrder)
            if ($sellerOrder->status == SellerOrderStatusEnum::CANCELLED_BY_SELLER || $sellerOrder->status == SellerOrderStatusEnum::SHIPPED)
                $count++;
        if ($count == $allCount)
            $sellerOrder->order->update(['status' => Order::STATUS_COMPLETED]);



        foreach ($sellerOrder->order->sellerOrders as $sellerOrder)
            if ($sellerOrder->status == SellerOrderStatusEnum::CANCELLED_BY_SELLER)
                $cancelledCount++;
        if ($cancelledCount == $allCount)
            $sellerOrder->order->update(['status' => Order::STATUS_CANCELED]);
    }


    /**
     * @param SellerOrder $sellerOrder
     * @return void
     */
    public function ready(SellerOrder $sellerOrder)
    {
        $sellerOrder->setStatus(SellerOrderStatusEnum::READY_FOR_PICKUP);
    }


    public function shipped(SellerOrder $sellerOrder)
    {
        $sellerOrder->setStatus(SellerOrderStatusEnum::SHIPPED);
        $sellerOrder->package->lastTransaction()->update(['until' => now()]);

        $count = 0;
        $allCount = $sellerOrder->order->sellerOrders()->count();
        foreach ($sellerOrder->order->sellerOrders as $sellerOrder)
            if ($sellerOrder->status == SellerOrderStatusEnum::CANCELLED_BY_SELLER || $sellerOrder->status == SellerOrderStatusEnum::SHIPPED)
                $count++;
        if ($count == $allCount)
            $sellerOrder->order->update(['status' => Order::STATUS_COMPLETED]);
    }
}
