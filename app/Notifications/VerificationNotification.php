<?php

namespace App\Notifications;

use Alhelwany\LaravelMtn\Channels\MTNChannel;
use Alhelwany\LaravelMtn\Enums\Lang;
use Alhelwany\LaravelMtn\Interfaces\MTNNotification;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Notification;

class VerificationNotification extends Notification implements MTNNotification, ShouldQueue
{
    use Queueable;

    public function __construct(private string $code)
    {
    }

    public function via(object $notifiable): array
    {
        return [MTNChannel::class];
    }

    public function toText(): string
    {
        return 'رمز التحقق الخاص بك هو: ' . $this->code;
    }

    public function getLang(): Lang
    {
        return Lang::AR;
    }
}
