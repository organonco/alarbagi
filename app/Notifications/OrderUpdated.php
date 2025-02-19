<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use NotificationChannels\Fcm\FcmChannel;
use NotificationChannels\Fcm\FcmMessage;
use NotificationChannels\Fcm\Resources\Notification as FcmNotification;

class OrderUpdated extends Notification
{
	use Queueable;

	public function __construct(private $order_id) {}

	public function via(object $notifiable): array
	{
		return ['database', FcmChannel::class];
	}

	public function toArray(object $notifiable): array
	{
		return [
			'text' => trans("marketplace::app.notifications.OrderUpdated"),
			'link' => route('shop.customers.account.orders.view', $this->order_id)
		];
	}

	public function toFcm($notifiable): FcmMessage
	{
		return new FcmMessage(notification: new FcmNotification(
			title: trans("marketplace::app.notifications.OrderUpdated"),
		));
	}
}
