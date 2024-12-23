<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;

class OrderUpdated extends Notification
{
	use Queueable;

	public function __construct(private $order_id) {}

	public function via(object $notifiable): array
	{
		return ['database'];
	}

	public function toArray(object $notifiable): array
	{
		return [
			'text' => trans("marketplace::app.notifications.OrderUpdated"),
			'link' => route('shop.customers.account.orders.view', $this->order_id)
		];
	}
}
