<?php

namespace Webkul\Notification\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;
use Organon\Marketplace\Models\Order;

class UpdateOrderNotification implements ShouldBroadcast, InternalNotificationInterface
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    /**
     * Create a new event instance.
     *
     * @return void
     */
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
     * Broadcast with data.
     *
     * @return array
     */
    public function broadcastWith()
    {
        return $this->data;
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
        return 'update-notification';
    }

    public function getText(): string
    {
        // TODO: Implement getText() method.
    }

    public function getRoute(): string
    {
        // TODO: Implement getRoute() method.
    }

    public function getRouteParams(): string
    {
        // TODO: Implement getRouteParams() method.
    }
}
