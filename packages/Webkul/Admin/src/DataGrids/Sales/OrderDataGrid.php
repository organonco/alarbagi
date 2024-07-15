<?php

namespace Webkul\Admin\DataGrids\Sales;

use Illuminate\Support\Facades\DB;
use Webkul\DataGrid\DataGrid;
use Webkul\Sales\Models\OrderAddress;
use Webkul\Sales\Repositories\OrderRepository;

class OrderDataGrid extends DataGrid
{
    /**
     * Prepare query builder.
     *
     * @return \Illuminate\Database\Query\Builder
     */
    public function prepareQueryBuilder()
    {
        $queryBuilder = DB::table('orders')->orderBy('created_at', 'DESC')
            ->leftJoin('addresses as order_address_shipping', function ($leftJoin) {
                $leftJoin->on('order_address_shipping.order_id', '=', 'orders.id')
                    ->where('order_address_shipping.address_type', OrderAddress::ADDRESS_TYPE_SHIPPING);
            })
            ->leftJoin('areas', function($join){
                $join->on('order_address_shipping.area_id', '=', 'areas.id');
            })
            ->leftJoin('order_payment', 'orders.id', '=', 'order_payment.order_id')
            ->leftJoin('seller_orders', 'seller_orders.order_id', '=', 'orders.id')
            ->groupBy('orders.id')
            ->select(
                DB::raw('count(1) as number_of_sellers'),
                'orders.id',
                'order_payment.method',
                'orders.increment_id',
                'orders.base_grand_total',
                'orders.created_at',
                'orders.status',
                'customer_email',
                'orders.cart_id as image',
                DB::raw('CONCAT(' . DB::getTablePrefix() . 'orders.customer_first_name, " ", ' . DB::getTablePrefix() . 'orders.customer_last_name) as full_name'),
                DB::raw('(CASE WHEN orders.shipping_method = "pickup_pickup" THEN "" ELSE areas.name END) AS area'),
                'orders.shipping_title',
                'order_address_shipping.name as address_name',
            );

        $this->addFilter('full_name', DB::raw('CONCAT(' . DB::getTablePrefix() . 'orders.customer_first_name, " ", ' . DB::getTablePrefix() . 'orders.customer_last_name)'));
        $this->addFilter('created_at', 'orders.created_at');

        return $queryBuilder;
    }

    /**
     * Add columns.
     *
     * @return void
     */
    public function prepareColumns()
    {
        $this->addColumn([
            'index'      => 'increment_id',
            'label'      => trans('admin::app.sales.orders.index.datagrid.order-id'),
            'type'       => 'string',
            'searchable' => true,
            'filterable' => false,
            'sortable'   => true,
            'closure' => fn($row) => $row->increment_id . " (عدد البائعين: $row->number_of_sellers)"
        ]);

        $this->addColumn([
            'index'      => 'shipping_method',
            'label'      => trans('admin::app.sales.orders.index.datagrid.shipping-method'),
            'type'       => 'string',
            'searchable' => false,
            'filterable' => false,
            'sortable'   => false,
        ]);

        $this->addColumn([
            'index'      => 'area',
            'label'      => trans('admin::app.sales.orders.index.datagrid.area'),
            'type'       => 'string',
            'searchable' => false,
            'filterable' => false,
            'sortable'   => false,
        ]);

        $this->addColumn([
            'index'      => 'status',
            'label'      => trans('admin::app.sales.orders.index.datagrid.status'),
            'type'       => 'checkbox',
            'options'    => [
                'processing'      => trans('admin::app.sales.orders.index.datagrid.processing'),
                'completed'       => trans('admin::app.sales.orders.index.datagrid.completed'),
                'canceled'        => trans('admin::app.sales.orders.index.datagrid.canceled'),
                'closed'          => trans('admin::app.sales.orders.index.datagrid.closed'),
                'pending'         => trans('admin::app.sales.orders.index.datagrid.pending'),
                'pending_payment' => trans('admin::app.sales.orders.index.datagrid.pending-payment'),
                'fraud'           => trans('admin::app.sales.orders.index.datagrid.fraud'),
            ],
            'searchable' => true,
            'filterable' => false,
            'sortable'   => true,
            'closure'    => function ($row) {
                switch ($row->status) {
                    case 'processing':
                        return '<p class="label-processing">' . trans('admin::app.sales.orders.index.datagrid.processing') . '</p>';

                    case 'completed':
                        return '<p class="label-active">' . trans('admin::app.sales.orders.index.datagrid.completed') . '</p>';

                    case 'canceled':
                        return '<p class="label-cancelled">' . trans('admin::app.sales.orders.index.datagrid.canceled') . '</p>';

                    case 'closed':
                        return '<p class="label-closed">' . trans('admin::app.sales.orders.index.datagrid.closed') . '</p>';

                    case 'pending':
                        return '<p class="label-pending">' . trans('admin::app.sales.orders.index.datagrid.pending') . '</p>';

                    case 'pending_payment':
                        return '<p class="label-pending">' . trans('admin::app.sales.orders.index.datagrid.pending-payment') . '</p>';

                    case 'fraud':
                        return '<p class="label-cancelled">' . trans('admin::app.sales.orders.index.datagrid.fraud') . '</p>';
                }
            },
        ]);

        $this->addColumn([
            'index'      => 'base_grand_total',
            'label'      => trans('admin::app.sales.orders.index.datagrid.grand-total'),
            'type'       => 'price',
            'searchable' => false,
            'filterable' => false,
            'sortable'   => true,
        ]);

        $this->addColumn([
            'index'      => 'method',
            'label'      => trans('admin::app.sales.orders.index.datagrid.pay-via'),
            'type'       => 'string',
            'searchable' => false,
            'filterable' => false,
            'sortable'   => false,
            'closure'    => function ($row) {
                return core()->getConfigData('sales.payment_methods.' . $row->method . '.title');
            },
        ]);


        $this->addColumn([
            'index'      => 'full_name',
            'label'      => trans('admin::app.sales.orders.index.datagrid.customer'),
            'type'       => 'string',
            'searchable' => true,
            'filterable' => true,
            'sortable'   => true,
        ]);

        /**
         * Searchable dropdown sample. In testing phase.
         */
        $this->addColumn([
            'index'      => 'customer_email',
            'label'      => trans('admin::app.sales.orders.index.datagrid.email'),
            'type'       => 'dropdown',
            'options'    => [
                'type'   => 'searchable',
                'params' => [
                    'repository' => \Webkul\Customer\Repositories\CustomerRepository::class,
                    'column'     => [
                        'label' => 'email',
                        'value' => 'email',
                    ],
                ],
            ],
            'searchable' => true,
            'filterable' => false,
            'sortable'   => false,
        ]);

        $this->addColumn([
            'index'      => 'location',
            'label'      => trans('admin::app.sales.orders.index.datagrid.location'),
            'type'       => 'string',
            'searchable' => false,
            'filterable' => false,
            'sortable'   => false,
        ]);

        $this->addColumn([
            'index'      => 'image',
            'label'      => trans('admin::app.sales.orders.index.datagrid.images'),
            'type'       => 'string',
            'searchable' => false,
            'filterable' => false,
            'sortable'   => false,
            'closure'    => function ($value) {
                $order = app(OrderRepository::class)->with('items')->find($value->id);

                return view('admin::sales.orders.images', compact('order'))->render();
            },
        ]);

        $this->addColumn([
            'index'      => 'created_at',
            'label'      => trans('admin::app.sales.orders.index.datagrid.date'),
            'type'       => 'date_range',
            'searchable' => false,
            'filterable' => true,
            'sortable'   => true,
        ]);
    }

    /**
     * Prepare actions.
     *
     * @return void
     */
    public function prepareActions()
    {
        if (bouncer()->hasPermission('sales.orders.view')) {
            $this->addAction([
                'icon'   => 'icon-view',
                'title'  => trans('admin::app.sales.orders.index.datagrid.view'),
                'method' => 'GET',
                'url'    => function ($row) {
                    return route('admin.sales.orders.view', $row->id);
                },
            ]);
        }
    }
}
