<?php

namespace Organon\Marketplace\Enums;

enum SellerOrderStatusEnum : string
{
    case PENDING = 'Pending';
    case APPROVED = 'Approved';
    case CANCELLED = 'Cancelled';
    case PICKED_UP = 'Picked Up';
    case SHIPPED = 'Shipped';

}
