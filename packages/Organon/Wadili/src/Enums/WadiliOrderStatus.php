<?php

namespace Organon\Wadili\Enums;

enum WadiliOrderStatus : string{
    case PENDING = "Pending";
    case UNREAD = "UnRead";
    case ACCEPTED = "Accepted";
    case REJECTED = "Rejected";
    case DELIVERING = "Delivering";
    case DELIVERED = "Delivered";
}
