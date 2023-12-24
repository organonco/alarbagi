<?php

namespace Webkul\Notification\Events;

interface InternalNotificationInterface
{
    public function getText() : string;
    public function getRoute() : string;
    public function getRouteParams(): string;
}