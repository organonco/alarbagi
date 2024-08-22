<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;

class OfferCreated extends Notification
{
	use Queueable;

	public function __construct() {}

	public function via(object $notifiable): array
	{
		return ['database'];
	}

	public function toArray(object $notifiable): array
	{
		return [
			'text' => trans("marketplace::app.notifications.OfferCreated"),
			'link' => route('offer.index')
		];
	}
}
