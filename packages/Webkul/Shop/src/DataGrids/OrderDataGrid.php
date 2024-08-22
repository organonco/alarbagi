<?php

namespace Webkul\Shop\DataGrids;

use Illuminate\Support\Facades\DB;
use Webkul\DataGrid\DataGrid;

class OrderDataGrid extends DataGrid
{
	/**
	 * Prepare query builder.
	 *
	 * @return void
	 */
	public function prepareQueryBuilder()
	{
		$queryBuilder = DB::table('orders')
			->addSelect(
				'orders.id',
				'orders.increment_id',
				'orders.status',
				'orders.created_at',
				'orders.base_grand_total',
				'orders.order_currency_code'
			)
			->where('customer_id', auth()->guard('customer')->user()->id);

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
			'index'      => 'created_at',
			'label'      => trans('shop::app.customers.account.orders.order-date'),
			'type'       => 'date_range',
			'searchable' => true,
			'sortable'   => true,
			'filterable' => true,
			'closure'    => function ($row) {
				return date('d/m', strtotime($row->created_at));
			},
		]);

		$this->addColumn([
			'index'      => 'grand_total',
			'label'      => trans('shop::app.customers.account.orders.total'),
			'type'       => 'integer',
			'searchable' => true,
			'sortable'   => true,
			'filterable' => true,
			'closure'    => function ($row) {
				return core()->formatPrice($row->base_grand_total, $row->order_currency_code);
			},
		]);

		$this->addColumn([
			'index'      => 'status',
			'label'      => trans('shop::app.customers.account.orders.status.title'),
			'type'       => 'text',
			'searchable' => true,
			'sortable'   => true,
			'filterable' => false,
			'closure'    => function ($row) {
				return "
					<span class=\"label-" . trans('marketplace::app.order.statuses.' . $row->status . '.class') . " text-[14px] mx-[5px]\">" .
					trans('marketplace::app.order.statuses.' . $row->status . '.label') .
					"</span>";
			},
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
			'icon'   => 'icon-eye',
			'title'  => trans('ui::app.datagrid.view'),
			'method' => 'GET',
			'url'    => function ($row) {
				return route('shop.customers.account.orders.view', $row->id);
			},
		]);
	}
}
