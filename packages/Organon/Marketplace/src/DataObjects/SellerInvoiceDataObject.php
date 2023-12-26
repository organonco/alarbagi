<?php

namespace Organon\Marketplace\DataObjects;

use Organon\Marketplace\Enums\SellerInvoiceItemTypeEnum;
use Organon\Marketplace\Enums\SellerInvoiceStatusEnum;

class SellerInvoiceDataObject
{

    private float $subtotal;
    private float $extras;
    private float $total;


    /**
     * @param SellerInvoiceStatusEnum $status
     * @param SellerInvoiceItemDataObject[] $items
     */
    public function __construct(
        private SellerInvoiceStatusEnum $status,
        private array                   $items,
        private int                     $seller_id
    )
    {
        $this->calculateSubtotal();
        $this->calculateExtras();
        $this->calculateTotal();
    }


    public function getSubtotal(): float
    {
        return $this->subtotal;
    }

    public function getTotal(): float
    {
        return $this->total;
    }

    public function getExtras(): float
    {
        return $this->extras;
    }

    /**
     * @return SellerInvoiceItemDataObject[]
     */
    public function getItems(): array
    {
        return $this->items;
    }

    public function getStatus(): SellerInvoiceStatusEnum
    {
        return $this->status;
    }

    public function getSellerId()
    {
        return $this->seller_id;
    }

    private function calculateSubtotal()
    {
        $subtotal = 0;
        foreach ($this->items as $item)
            if ($item->getType() == SellerInvoiceItemTypeEnum::ORDER)
                $subtotal += $item->getAmount();
        $this->subtotal = $subtotal;
    }

    private function calculateExtras()
    {
        $extras = 0;
        foreach ($this->items as $item)
            if ($item->getType() == SellerInvoiceItemTypeEnum::EXTRA)
                $extras += $item->getAmount();
        $this->extras = $extras;
    }

    private function calculateTotal()
    {
        $this->total = $this->subtotal + $this->extras;
    }


    public function toJson()
    {
        return json_encode($this->toArray());
    }

    public function toArray(): array
    {
        $itemsArray = [];
        foreach ($this->getItems() as $item)
            $itemsArray[] = $item->toArray();

        return [
            'subtotal' => $this->getSubtotal(),
            'extras' => $this->getExtras(),
            'total' => $this->getTotal(),
            'status' => $this->getStatus(),
            'seller_id' => $this->getSellerId(),
            'items' => $itemsArray
        ];
    }

}