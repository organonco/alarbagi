<?php

namespace Organon\Marketplace\Enums;

enum SellerInvoiceItemTypeEnum: string
{
    case ORDER = 'order';
    case EXTRA = 'extra';
    case FEE = 'fee';

}
