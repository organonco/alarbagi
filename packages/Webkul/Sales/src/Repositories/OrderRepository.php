<?php

namespace Webkul\Sales\Repositories;

use App\WadiliOrder;
use Illuminate\Container\Container;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\Facades\Log;
use Organon\Marketplace\Enums\SellerOrderStatusEnum;
use Organon\Marketplace\Models\Order;
use Organon\Marketplace\Notifications\Repositories\SellerOrderRepository;
use Webkul\Core\Eloquent\Repository;
use Webkul\Sales\Generators\OrderSequencer;
use Webkul\Sales\Models\Order as OrderModel;

class OrderRepository extends Repository
{
    /**
     * @param OrderItemRepository $orderItemRepository
     * @param DownloadableLinkPurchasedRepository $downloadableLinkPurchasedRepository
     * @param SellerOrderRepository $sellerOrderRepository
     * @param Container $container
     */
    public function __construct(
        protected OrderItemRepository                 $orderItemRepository,
        protected DownloadableLinkPurchasedRepository $downloadableLinkPurchasedRepository,
        protected SellerOrderRepository               $sellerOrderRepository,
        Container                                     $container
    )
    {
        parent::__construct($container);
    }

    /**
     * Specify model class name.
     *
     * @return string
     */
    public function model(): string
    {
        return Order::class;
    }

    /**
     * This method will try attempt to a create order.
     *
     * @return \Webkul\Sales\Contracts\Order
     */
    public function createOrderIfNotThenRetry(array $data)
    {
        DB::beginTransaction();

        try {
            Event::dispatch('checkout.order.save.before', [$data]);

            if (!empty($data['customer'])) {
                $data['customer_id'] = $data['customer']->id;
                $data['customer_type'] = get_class($data['customer']);
            } else {
                unset($data['customer']);
            }

            if (!empty($data['channel'])) {
                $data['channel_id'] = $data['channel']->id;
                $data['channel_type'] = get_class($data['channel']);
                $data['channel_name'] = $data['channel']->name;
            } else {
                unset($data['channel']);
            }

            $data['status'] = 'pending';

            $order = $this->model->create(array_merge($data, ['increment_id' => $this->generateIncrementId()]));

            $order->payment()->create($data['payment']);

            if (isset($data['shipping_address'])) {
                unset($data['shipping_address']['customer_id']);

                $order->addresses()->create($data['shipping_address']);
            }

            unset($data['billing_address']['customer_id']);

            $order->addresses()->create($data['billing_address']);

            foreach ($data['items'] as $item) {

                $orderItem = $this->orderItemRepository->create(array_merge($item, ['order_id' => $order->id]));

                if (!empty($item['children'])) {
                    foreach ($item['children'] as $child) {
                        $this->orderItemRepository->create(array_merge($child, ['order_id' => $order->id, 'parent_id' => $orderItem->id]));
                    }
                }

                $this->orderItemRepository->manageInventory($orderItem);

                $this->downloadableLinkPurchasedRepository->saveLinks($orderItem, 'available');

            }

            $suborders = collect($data['items'])
                ->whereNotNull('product.seller_id')
                ->groupBy('product.seller_id')
                ->map(function ($products, $seller_id) {
                    $sum = collect($products)->sum('total');
                    $taxSum = collect($products)->sum('tax_amount');
                    $total = $sum + $taxSum;
                    $numberOfProducts = collect($products)->sum('qty_ordered');

                    return [
                        'seller_id' => $seller_id,
                        'subtotal' => $sum,
                        'tax_amount' => $taxSum,
                        'grand_total' => $total,
                        'number_of_products' => $numberOfProducts
                    ];
                });

            $sellerOrders = $this->sellerOrderRepository->createMany($order, $suborders);
            if($data['shipping_method'] == 'wadili_wadili'){
                
                $wadiliOrder = WadiliOrder::findForCart($data['cart_id'], WadiliOrder::createCartHash(
                    $sellerOrders[0]->seller->lat,
                    $sellerOrders[0]->seller->lng,
                    $data['shipping_address']['lat'],
                    $data['shipping_address']['lng'],
                    $data['sub_total'],
                ));

                $wadiliOrder->update(['order_id' => $order->id]);
            }

        } catch (\Exception $e) {
            dd($e);
            DB::rollBack();
            Log::error(
                'OrderRepository:createOrderIfNotThenRetry: ' . $e->getMessage(),
                ['data' => $data]
            );
        } finally {
            DB::commit();
        }
        return $order;
    }

    /**
     * Create order.
     *
     * @param array $data
     * @return \Webkul\Sales\Contracts\Order
     */
    public function create(array $data, $note = "")
    {
		$data['note'] = $note;
        return $this->createOrderIfNotThenRetry($data);
    }

    /**
     * Cancel order. This method should be independent as admin also can cancel the order.
     *
     * @param \Webkul\Sales\Models\Order|int $orderOrId
     * @return \Webkul\Sales\Contracts\Order
     */
    public function cancel($orderOrId)
    {
        /* order */
        $order = $this->resolveOrderInstance($orderOrId);

        /* check wether order can be cancelled or not */
        if (!$order->canCancel()) {
            return false;
        }

        Event::dispatch('sales.order.cancel.before', $order);


        foreach($order->sellerOrders as $sellerOrder){
            $sellerOrder->setStatus(SellerOrderStatusEnum::CANCELLED);
        }


        foreach ($order->items as $item) {
            if (!$item->qty_to_cancel) {
                continue;
            }

            $orderItems = [];

            if ($item->getTypeInstance()->isComposite()) {
                foreach ($item->children as $child) {
                    $orderItems[] = $child;
                }
            } else {
                $orderItems[] = $item;
            }

            foreach ($orderItems as $orderItem) {
                $this->orderItemRepository->returnQtyToProductInventory($orderItem);

                if ($orderItem->qty_ordered) {
                    $orderItem->qty_canceled += $orderItem->qty_to_cancel;
                    $orderItem->save();

                    if (
                        $orderItem->parent
                        && $orderItem->parent->qty_ordered
                    ) {
                        $orderItem->parent->qty_canceled += $orderItem->parent->qty_to_cancel;
                        $orderItem->parent->save();
                    }
                } else {
                    $orderItem->parent->qty_canceled += $orderItem->parent->qty_to_cancel;
                    $orderItem->parent->save();
                }
            }

            $this->downloadableLinkPurchasedRepository->updateStatus($item, 'expired');
        }

        $this->updateOrderStatus($order);

        Event::dispatch('sales.order.cancel.after', $order);

        return true;
    }

    /**
     * Generate increment id.
     *
     * @return int
     */
    public function generateIncrementId()
    {
        return app(OrderSequencer::class)->resolveGeneratorClass();
    }

    /**
     * Is order in completed state.
     *
     * @param \Webkul\Sales\Contracts\Order $order
     * @return void
     */
    public function isInCompletedState($order)
    {
        $totalQtyOrdered = $totalQtyInvoiced = $totalQtyShipped = $totalQtyRefunded = $totalQtyCanceled = 0;

        foreach ($order->items()->get() as $item) {
            $totalQtyOrdered += $item->qty_ordered;
            $totalQtyInvoiced += $item->qty_invoiced;

            if (!$item->isStockable()) {
                $totalQtyShipped += $item->qty_invoiced;
            } else {
                $totalQtyShipped += $item->qty_shipped;
            }

            $totalQtyRefunded += $item->qty_refunded;
            $totalQtyCanceled += $item->qty_canceled;
        }

        if (
            $totalQtyOrdered != ($totalQtyRefunded + $totalQtyCanceled)
            && $totalQtyOrdered == $totalQtyInvoiced + $totalQtyCanceled
            && $totalQtyOrdered == $totalQtyShipped + $totalQtyRefunded + $totalQtyCanceled
        ) {
            return true;
        }

        /**
         * If order is already completed and total quantity ordered is not equal to refunded
         * then it can be considered as completed.
         */
        if (
            $order->status === OrderModel::STATUS_COMPLETED
            && $totalQtyOrdered != $totalQtyRefunded
        ) {
            return true;
        }

        return false;
    }

    /**
     * Is order in cancelled state.
     *
     * @param \Webkul\Sales\Contracts\Order $order
     * @return void
     */
    public function isInCanceledState($order)
    {
        $totalQtyOrdered = $totalQtyCanceled = 0;

        foreach ($order->items()->get() as $item) {
            $totalQtyOrdered += $item->qty_ordered;
            $totalQtyCanceled += $item->qty_canceled;
        }

        return $totalQtyOrdered === $totalQtyCanceled;
    }

    /**
     * Is order in closed state.
     *
     * @param mixed $order
     * @return void
     */
    public function isInClosedState($order)
    {
        $totalQtyOrdered = $totalQtyRefunded = $totalQtyCanceled = 0;

        foreach ($order->items()->get() as $item) {
            $totalQtyOrdered += $item->qty_ordered;
            $totalQtyRefunded += $item->qty_refunded;
            $totalQtyCanceled += $item->qty_canceled;
        }

        return $totalQtyOrdered === $totalQtyRefunded + $totalQtyCanceled;
    }

    /**
     * Update order status.
     *
     * @param \Webkul\Sales\Contracts\Order $order
     * @param string $orderState
     * @return void
     */
    public function updateOrderStatus($order, $orderState = null)
    {
        Event::dispatch('sales.order.update-status.before', $order);

        if (!empty($orderState)) {
            $status = $orderState;
        } else {
            $status = "processing";

            if ($this->isInCompletedState($order)) {
                $status = 'completed';
            }

            if ($this->isInCanceledState($order)) {
                $status = 'canceled';
            } elseif ($this->isInClosedState($order)) {
                $status = 'closed';
            }
        }

        $order->status = $status;
        $order->save();

        Event::dispatch('sales.order.update-status.after', $order);
    }

    /**
     * Collect totals.
     *
     * @param \Webkul\Sales\Contracts\Order $order
     * @return mixed
     */
    public function collectTotals($order)
    {
        // order invoice total
        $order->sub_total_invoiced = $order->base_sub_total_invoiced = 0;
        $order->shipping_invoiced = $order->base_shipping_invoiced = 0;
        $order->tax_amount_invoiced = $order->base_tax_amount_invoiced = 0;
        $order->discount_invoiced = $order->base_discount_invoiced = 0;

        foreach ($order->invoices as $invoice) {
            $order->sub_total_invoiced += $invoice->sub_total;
            $order->base_sub_total_invoiced += $invoice->base_sub_total;

            $order->shipping_invoiced += $invoice->shipping_amount;
            $order->base_shipping_invoiced += $invoice->base_shipping_amount;

            $order->tax_amount_invoiced += $invoice->tax_amount;
            $order->base_tax_amount_invoiced += $invoice->base_tax_amount;

            $order->discount_invoiced += $invoice->discount_amount;
            $order->base_discount_invoiced += $invoice->base_discount_amount;
        }

        $order->grand_total_invoiced = $order->sub_total_invoiced + $order->shipping_invoiced + $order->tax_amount_invoiced - $order->discount_invoiced;
        $order->base_grand_total_invoiced = $order->base_sub_total_invoiced + $order->base_shipping_invoiced + $order->base_tax_amount_invoiced - $order->base_discount_invoiced;

        // order refund total
        $order->sub_total_refunded = $order->base_sub_total_refunded = 0;
        $order->shipping_refunded = $order->base_shipping_refunded = 0;
        $order->tax_amount_refunded = $order->base_tax_amount_refunded = 0;
        $order->discount_refunded = $order->base_discount_refunded = 0;
        $order->grand_total_refunded = $order->base_grand_total_refunded = 0;

        foreach ($order->refunds as $refund) {
            $order->sub_total_refunded += $refund->sub_total;
            $order->base_sub_total_refunded += $refund->base_sub_total;

            $order->shipping_refunded += $refund->shipping_amount;
            $order->base_shipping_refunded += $refund->base_shipping_amount;

            $order->tax_amount_refunded += $refund->tax_amount;
            $order->base_tax_amount_refunded += $refund->base_tax_amount;

            $order->discount_refunded += $refund->discount_amount;
            $order->base_discount_refunded += $refund->base_discount_amount;

            $order->grand_total_refunded += $refund->adjustment_refund - $refund->adjustment_fee;
            $order->base_grand_total_refunded += $refund->base_adjustment_refund - $refund->base_adjustment_fee;
        }

        $order->grand_total_refunded += $order->sub_total_refunded + $order->shipping_refunded + $order->tax_amount_refunded - $order->discount_refunded;
        $order->base_grand_total_refunded += $order->base_sub_total_refunded + $order->base_shipping_refunded + $order->base_tax_amount_refunded - $order->base_discount_refunded;

        $order->save();

        return $order;
    }

    /**
     * This method will find order if id is given else pass the order as it is.
     *
     * @param \Webkul\Sales\Models\Order|int $orderOrId
     * @return \Webkul\Sales\Contracts\Order
     */
    private function resolveOrderInstance($orderOrId)
    {
        return $orderOrId instanceof OrderModel
            ? $orderOrId
            : $this->findOrFail($orderOrId);
    }
}
