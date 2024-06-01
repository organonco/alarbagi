<?php

namespace Organon\Delivery\Enums;

enum TripStatusEnum: string
{
    case PENDING = "pending";
    case IN_PROGRESS = "in-progress";
    case DONE = "done";
}
