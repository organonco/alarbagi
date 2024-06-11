<?php

namespace Organon\Marketplace\Notifications\Repositories;

use Organon\Marketplace\DataObjects\SellerInvoiceDataObject;
use Organon\Marketplace\DataObjects\SellerInvoiceItemDataObject;
use Organon\Marketplace\Enums\SellerInvoiceItemTypeEnum;
use Organon\Marketplace\Enums\SellerInvoiceStatusEnum;
use Organon\Marketplace\Enums\SellerOrderStatusEnum;
use Organon\Marketplace\Models\Seller;
use Organon\Marketplace\Models\SellerInvoice;
use Organon\Marketplace\Models\SellerInvoiceItem;
use Webkul\Core\Eloquent\Repository;

class SellerInvoiceRepository extends Repository
{
    /**
     * Specify Model class name
     *
     * @return mixed
     */
    function model()
    {
        return 'Organon\Marketplace\Contracts\SellerInvoice';
    }

    private function createDataObject(Seller $seller)
    {
        $invoiceItems = [];
        $sellerOrders = $seller->sellerOrders()->where('status', SellerOrderStatusEnum::APPROVED->value)->get();
        $total = 0;

        //Seller Orders
        foreach ($sellerOrders as $sellerOrder) {
            $total += $sellerOrder->grand_total;
            $invoiceItems[] = new SellerInvoiceItemDataObject(
                $sellerOrder->grand_total,
                SellerInvoiceItemTypeEnum::ORDER,
                "Order #" . $sellerOrder->order_id . " - " . $sellerOrder->created_at->format('d/m/Y'),
                $sellerOrder
            );
        }
        //Fees
        $percentage = config('invoice.percentage');
        if ($total > 0)
            $invoiceItems[] = new SellerInvoiceItemDataObject(-1 * $total * $percentage / 100, SellerInvoiceItemTypeEnum::FEE, "Alarbaji Fees: ($total AED x $percentage%)", null);

        $invoice = new SellerInvoiceDataObject(SellerInvoiceStatusEnum::DRAFT, $invoiceItems, $seller->id);
        return $invoice;
    }

    public function generate(Seller $seller)
    {
        return $this->fromDataObject($this->createDataObject($seller));
    }

    private function fromDataObject(SellerInvoiceDataObject $dataObject)
    {
        $data = $dataObject->toArray();
        $sellerInvoice = SellerInvoice::create($data);
        foreach ($data['items'] as $item)
            SellerInvoiceItem::create(array_merge($item, ['seller_invoice_id' => $sellerInvoice->id]));
        return $sellerInvoice;
    }

    public function addItem($invoice_id, $comment, $amount)
    {
        $data = [
            'comment' => $comment,
            'amount' => $amount,
            'type' => SellerInvoiceItemTypeEnum::EXTRA,
        ];
        $invoice = $this->find($invoice_id);
        $invoice->items()->create($data);
        $invoice->recalculate();
    }

    public function deleteItem($item_id, $invoice_id)
    {
        SellerInvoiceItem::find($item_id)->delete();
        $invoice = $this->find($invoice_id);
        $invoice->recalculate();
    }

    public function sendToSeller($invoice_id)
    {
        $this->find($invoice_id)->setStatus(SellerInvoiceStatusEnum::PENDING);
    }

    public function unsendToSeller($invoice_id)
    {
        $this->find($invoice_id)->setStatus(SellerInvoiceStatusEnum::DRAFT);
    }

    public function approve($invoice_id)
    {
        $this->find($invoice_id)->setStatus(SellerInvoiceStatusEnum::APPROVED);
    }

    public function reject($invoice_id)
    {
        $this->find($invoice_id)->setStatus(SellerInvoiceStatusEnum::REJECTED);
    }

    public function issue($invoice_id)
    {
        $this->find($invoice_id)->setStatus(SellerInvoiceStatusEnum::ISSUED);
    }
}
