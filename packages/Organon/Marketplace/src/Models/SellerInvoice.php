<?php

namespace Organon\Marketplace\Models;

use Illuminate\Database\Eloquent\Model;
use Organon\Marketplace\Contracts\SellerInvoice as SellerInvoiceContract;
use Organon\Marketplace\Enums\SellerInvoiceItemTypeEnum;
use Organon\Marketplace\Enums\SellerInvoiceStatusEnum;
use Organon\Marketplace\Traits\HasStatusTrait;

class SellerInvoice extends Model implements SellerInvoiceContract
{
    use HasStatusTrait;

    protected $fillable = [
        'subtotal',
        'extras',
        'fees',
        'total',
        'status',
        'seller_id'
    ];


    public function items()
    {
        return $this->hasMany(SellerInvoiceItem::class);
    }

    public static function getStatusEnum(): string
    {
        return SellerInvoiceStatusEnum::class;
    }

    protected static function getDefaultStatus()
    {
        return SellerInvoiceStatusEnum::DRAFT;
    }

    public function seller()
    {
        return $this->belongsTo(Seller::class);
    }

    public function recalculate()
    {
        $items = $this->items()->get();
        $subtotal = $items->where('type', SellerInvoiceItemTypeEnum::ORDER)->sum('amount');
        $extras = $items->where('type', SellerInvoiceItemTypeEnum::EXTRA)->sum('amount');
        $total = $subtotal + $extras;
        $this->update([
            'subtotal' => $subtotal,
            'extras' => $extras,
            'total' => $total
        ]);
    }
}
