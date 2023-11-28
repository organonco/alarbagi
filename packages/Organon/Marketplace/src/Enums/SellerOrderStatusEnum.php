<?php

namespace Organon\Marketplace\Enums;

enum SellerOrderStatusEnum : string
{
    case PENDING = 'pending';
    case APPROVED = 'approved';
    case CANCELLED = 'cancelled';
    case PICKED_UP = 'picked-up';
    case SHIPPED = 'shipped';

}
