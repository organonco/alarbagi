<?php

namespace Webkul\Notification\Listeners;

use Organon\Marketplace\Models\SellerOrder;
use Webkul\Notification\Events\CreateSellerOrderNotification;
use Webkul\Notification\Events\InternalNotificationInterface;
use Webkul\Notification\Repositories\NotificationRepository;
use Webkul\Notification\Events\CreateOrderNotification;
use Webkul\Notification\Events\UpdateOrderNotification;

class Order
{
    /**
     * Create a new listener instance.
     *
     * @return void
     */
    public function __construct(private NotificationRepository $notificationRepository)
    {
    }

    /**
     * Create a new resource.
     *
     * @return void
     */
    public function createOrder($order)
    {
        $this->notificationRepository->fromInternalNotification(new CreateOrderNotification($order), null);
        /** @var SellerOrder $sellerOrder */
        foreach ($order->sellerOrders as $sellerOrder) {
            $this->notificationRepository->fromInternalNotification(new CreateSellerOrderNotification($sellerOrder), $sellerOrder->seller->admin->id);
        }

    }

    /**
     * Fire an Event when the order status is updated.
     *
     * @return void
     */
    public function updateOrder($order)
    {

    }


}
