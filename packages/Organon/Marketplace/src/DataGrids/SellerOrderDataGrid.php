<?php

namespace Organon\Marketplace\DataGrids;

use Illuminate\Support\Facades\DB;
use Organon\Marketplace\Enums\SellerOrderStatusEnum;
use Organon\Marketplace\Models\Admin;
use Organon\Marketplace\Models\SellerOrder;
use Webkul\DataGrid\DataGrid;
use Webkul\Sales\Models\OrderAddress;

class SellerOrderDataGrid extends DataGrid
{

    public function prepareQueryBuilder()
    {

        /** @var Admin $admin */
        $admin = auth('admin')->user();

        $query = DB::table('seller_orders')->orderBy('created_at', 'DESC');
        $query->where('seller_id', $admin->getSellerId());

        $query->join('orders', 'order_id', '=', 'orders.id');
        $query->leftJoin('order_payment', 'orders.id', '=', 'order_payment.order_id');
        $query->join('addresses as order_address_shipping', function ($leftJoin) {
            $leftJoin->on('order_address_shipping.order_id', '=', 'orders.id')
                ->where('order_address_shipping.address_type', OrderAddress::ADDRESS_TYPE_SHIPPING);
        });


        $query->addSelect('orders.increment_id as increment_id');
        $query->addSelect('orders.id');
        $query->addSelect('orders.created_at as created_at');
        $query->addSelect('orders.customer_first_name as customer_first_name');
        $query->addSelect('orders.customer_last_name as customer_last_name');
        $query->addSelect('orders.customer_email');

        $query->addSelect('seller_orders.status');
        $query->addSelect('seller_orders.subtotal as subtotal');
        $query->addSelect('seller_orders.number_of_products as number_of_products');

        $query->addSelect('order_payment.method');

        $query->addSelect(DB::raw('CONCAT(' . DB::getTablePrefix() . 'order_address_shipping.city, ", ", ' . DB::getTablePrefix() . 'order_address_shipping.state,", ", ' . DB::getTablePrefix() . 'order_address_shipping.country) as customer_address'));

        return $query;
    }

    public function prepareColumns()
    {
        $this->addColumn([
            'index' => 'increment_id',
            'label' => trans('marketplace::app.admin.orders.index.datagrid.order-increment-id'),
            'type' => 'string',
            'searchable' => true,
            'filterable' => true,
            'sortable' => true,
        ]);
        $this->addColumn([
            'index' => 'seller_orders.status',
            'label' => trans('marketplace::app.admin.orders.index.datagrid.status'),
            'type' => 'dropdown',
            'options' => [
                'type' => 'basic',
                'params' => [
                    'options' => [
                        ['label' => trans('marketplace::app.admin.orders.index.datagrid.statuses.pending'), 'value' => 'pending'],
                    ],
                ],
            ],
            'searchable' => true,
            'filterable' => true,
            'sortable' => true,
            'closure' => function ($row) {
                return '<p class="label-' . trans('marketplace::app.seller-order.statuses.' . SellerOrder::getStatusFromValue($row->status)->name . '.class') . '">' . trans('marketplace::app.seller-order.statuses.' . SellerOrder::getStatusFromValue($row->status)->name . '.label') . '</p>';
            }
        ]);
        $this->addColumn([
            'index' => 'orders.created_at',
            'label' => trans('shop::app.customers.account.orders.order-date'),
            'type' => 'date_range',
            'searchable' => true,
            'sortable' => true,
            'filterable' => true,
        ]);

        $this->addColumn([
            'index' => 'customer_name',
            'label' => trans('marketplace::app.admin.orders.index.datagrid.customer-name'),
            'type' => 'string',
            'searchable' => false,
            'sortable' => false,
            'filterable' => false,
            'closure' => fn($row) => $row->customer_first_name . " " . $row->customer_last_name
        ]);

        $this->addColumn([
            'index' => 'subtotal',
            'label' => trans('marketplace::app.admin.orders.index.datagrid.subtotal'),
            'type' => 'string',
            'searchable' => false,
            'sortable' => true,
            'filterable' => false,
        ]);

        $this->addColumn([
            'index' => 'method',
            'label' => trans('admin::app.sales.orders.index.datagrid.pay-via'),
            'type' => 'string',
            'searchable' => false,
            'filterable' => false,
            'sortable' => false,
            'closure' => function ($row) {
                return core()->getConfigData('sales.payment_methods.' . $row->method . '.title');
            },
        ]);

        $this->addColumn([
            'index' => 'number_of_products',
            'label' => trans('marketplace::app.admin.orders.index.datagrid.number_of_products'),
            'type' => 'number',
            'searchable' => false,
            'filterable' => false,
            'sortable' => true,
        ]);

        $this->addColumn([
            'index'      => 'customer_address',
            'label'      => trans('marketplace::app.admin.orders.index.datagrid.customer_address'),
            'type'       => 'string',
            'searchable' => false,
            'filterable' => false,
            'sortable'   => false,
        ]);

        $this->addColumn([
            'index'      => 'customer_email',
            'label'      => trans('marketplace::app.admin.orders.index.datagrid.customer_email'),
            'type'       => 'string',
            'searchable' => false,
            'filterable' => false,
            'sortable'   => false,
        ]);

    }

    /**
     * Prepare actions.
     *
     * @return void
     */
    public function prepareActions()
    {
        $this->addAction([
            'icon' => 'icon-view',
            'title' => 'test',
            'method' => 'GET',
            'url' => function ($row) {
                return route('admin.sales.orders.index', $row->id);
            },
        ]);
    }
}
