<?php

namespace Webkul\Notification\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;
use Organon\Marketplace\Models\Order;

class CreateOrderNotification implements ShouldBroadcast, InternalNotificationInterface
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public function __construct(private Order $order)
    {
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return \Illuminate\Broadcasting\Channel|array
     */
    public function broadcastOn()
    {
        return new Channel('notification');
    }

    /**
     * Separate queue.
     *
     * Command: `php artisan queue:work --queue=broadcastable`
     *
     * @return string
     */
    public function broadcastQueue()
    {
        return 'broadcastable';
    }

    /**
     * Get the channels the event should broadcast as.
     *
     * @return string
     */
    public function broadcastAs()
    {
        return 'create-notification';
    }

    public function getText(): string
    {
        return 'New Order #' . $this->order->id;
    }

    public function getRoute(): string
    {
        return 'admin.sales.orders.view';
    }

    public function getRouteParams(): string
    {
        return json_encode(['id' => $this->order->id]);
    }
}
