<?php

namespace Organon\Marketplace\Enums;

enum SellerStatusEnum : string
{
    case PENDING = 'pending-approval';
    case ACTIVE = 'approved';
    case DEACTIVATED = 'deactivated';

}
