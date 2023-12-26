<?php

namespace Organon\Marketplace\DataObjects;

use Organon\Marketplace\Enums\SellerInvoiceItemTypeEnum;
use Organon\Marketplace\Models\SellerOrder;

class SellerInvoiceItemDataObject
{
    public function __construct(
        private float $amount,
        private SellerInvoiceItemTypeEnum $type,
        private ?string $comment,
        private ?SellerOrder $sellerOrder
    ){}

    public function getAmount(): float
    {
        return $this->amount;
    }

    public function getType() : SellerInvoiceItemTypeEnum
    {
        return $this->type;
    }

    public function getComment(): ?string
    {
        return $this->comment;
    }

    public function getSellerOrderId(): int
    {
        return $this->sellerOrderId;
    }

    public function toArray(): array
    {
        return [
            'amount' => $this->getAmount(),
            'type' => $this->getType(),
            'comment' => $this->getComment(),
            'seller_order_id' => $this->sellerOrder?->id,
            'order_id' => $this->sellerOrder?->order_id,
            'datetime' => $this->sellerOrder?->created_at->format('d/m/Y')
        ];
    }

}