<?php

namespace Organon\Marketplace\Models;

use Illuminate\Database\Eloquent\Model;
use Organon\Marketplace\Contracts\SellerInvoiceItem as SellerInvoiceItemContract;
use Organon\Marketplace\Enums\SellerInvoiceItemTypeEnum;
use Organon\Marketplace\Traits\HasTypeTrait;

class SellerInvoiceItem extends Model implements SellerInvoiceItemContract
{
    use HasTypeTrait;

    protected $fillable = [
        'amount',
        'type',
        'comment',
        'seller_invoice_id',
        'seller_order_id',
    ];

    public function invoice()
    {
        return $this->belongsTo(SellerInvoice::class);
    }

    public function sellerOrder()
    {
        return $this->belongsTo(SellerOrder::class);
    }

    public static function getTypeEnum(): string
    {
        return SellerInvoiceItemTypeEnum::class;
    }

}