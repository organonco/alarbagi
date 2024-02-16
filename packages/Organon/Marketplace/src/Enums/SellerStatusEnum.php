<?php

namespace Organon\Marketplace\Enums;

enum SellerStatusEnum : string
{
    case UNVERIFIED = "unverified";
    case PENDING = 'pending-approval';
    case ACTIVE = 'active';
    case DEACTIVATED = 'deactivated';
    case PAUSED = 'paused';

}
