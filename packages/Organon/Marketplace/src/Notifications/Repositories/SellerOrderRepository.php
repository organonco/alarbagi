<?php

namespace Organon\Marketplace\Notifications\Repositories;

use App\WadiliOrder;
use Organon\Marketplace\Models\SellerOrder;
use Organon\Marketplace\Enums\SellerOrderStatusEnum;
use Organon\Wadili\Carriers\Wadili;
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
        $sellerOrder->items()->update(['status' => 1]);
        $sellerOrder->order->refreshTotals();

        if ($sellerOrder->order->shipping_method == 'wadili_wadili') {
            Wadili::confirmOrder(WadiliOrder::findForOrder($sellerOrder->order->id));
        } else {
            // Refresh Status only when Wadili Approves Order
            $sellerOrder->order->refreshStatus();
        }
    }

    /**
     * @param SellerOrder $sellerOrder
     * @return void
     */
    public function cancel(SellerOrder $sellerOrder)
    {
        $sellerOrder->setStatus(SellerOrderStatusEnum::CANCELLED_BY_SELLER);
        $sellerOrder->items()->update(['status' => -1]);
        $sellerOrder->order->refreshStatus();
        $sellerOrder->order->refreshTotals();
    }
}
