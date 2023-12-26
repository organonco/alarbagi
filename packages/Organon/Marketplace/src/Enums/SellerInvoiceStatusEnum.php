<?php

namespace Organon\Marketplace\Enums;

enum SellerInvoiceStatusEnum : string
{
    case DRAFT = 'draft';
    case PENDING = 'pending';
    case APPROVED = 'approved';
    case REJECTED = 'cancelled';
    case ISSUED = 'issued';
}
