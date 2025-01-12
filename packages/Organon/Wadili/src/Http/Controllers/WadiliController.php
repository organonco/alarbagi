<?php

namespace Organon\Wadili\Http\Controllers;

use App\WadiliOrder;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Organon\Marketplace\Enums\SellerOrderStatusEnum;
use Organon\Marketplace\Models\Order;
use Organon\Marketplace\Notifications\Repositories\SellerOrderRepository;
use Organon\Wadili\Enums\WadiliOrderStatus;

class WadiliController extends Controller
{
    public function __construct(private SellerOrderRepository $sellerOrderRepository) {}

    public function hook(Request $request)
    {
        $orderId = $request->orderId;
        $orderStatus = $request->orderStatus;

        $wadiliOrder = WadiliOrder::findByWadiliOrderId($orderId);

        $newStatus = WadiliOrderStatus::tryFrom($orderStatus);

        if (!$newStatus)
            abort(403, "Invalid Status");

        if (!$wadiliOrder)
            abort(403, "Invalid Order Id");


        $order = $wadiliOrder->order;

        switch ($newStatus) {
            case WadiliOrderStatus::ACCEPTED:
                if ($wadiliOrder->status != WadiliOrderStatus::UNREAD->value)
                    abort(403, "Invalid Status");
                $order->refreshStatus();
                break;
            case WadiliOrderStatus::DELIVERING:
                if ($wadiliOrder->status != WadiliOrderStatus::ACCEPTED->value)
                    abort(403, "Invalid Status");
                $order->update(['status' => Order::STATUS_SHIPPING]);
                break;
            case WadiliOrderStatus::DELIVERED:
                if ($wadiliOrder->status != WadiliOrderStatus::DELIVERING->value)
                    abort(403, "Invalid Status");
                $order->update(['status' => Order::STATUS_COMPLETED]);
                break;
            case WadiliOrderStatus::REJECTED:
                if ($wadiliOrder->status != WadiliOrderStatus::UNREAD->value)
                    abort(403, "Invalid Status");
                foreach ($order->sellerOrders as $sellerOrder)
                    $this->sellerOrderRepository->cancel($sellerOrder);
                break;
        }
        
        $wadiliOrder->update(['status' => $orderStatus]);
    }
}
