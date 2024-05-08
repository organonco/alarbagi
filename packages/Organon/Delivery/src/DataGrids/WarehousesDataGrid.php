<?php

namespace Organon\Delivery\DataGrids;

use Illuminate\Support\Facades\DB;
use Organon\Marketplace\Traits\InteractsWithAuthenticatedAdmin;
use Webkul\DataGrid\DataGrid;

class WarehousesDataGrid extends DataGrid
{

    public function __construct(private $sellerId = null)
    {
        if ($this->sellerId == null)
            $this->sellerId = auth('admin')->user()->getSellerId();
    }

    public function prepareQueryBuilder()
    {

        $query = DB::table('warehouses')->orderBy('warehouses.created_at', 'DESC');

        if (!is_null($this->sellerId))
            $query->where('seller_id', $this->sellerId);

        $query->leftJoin('sellers', 'sellers.id', '=', 'warehouses.seller_id');

        $query->addSelect('warehouses.id as id');
        $query->addSelect('sellers.name as seller_name');
        $query->addSelect('warehouses.name as warehouse_name');
        $query->addSelect('warehouses.address as address');
        $query->addSelect('warehouses.emirate as emirate');

        return $query;
    }

    public function prepareColumns()
    {
        $this->addColumn([
            'index' => 'warehouse_name',
            'label' => trans('delivery::app.admin.datagrids.warehouse.warehouse_name'),
            'type' => 'string',
            'searchable' => true,
            'filterable' => true,
            'sortable' => true,
        ]);
        $this->addColumn([
            'index' => 'seller_name',
            'label' => trans('delivery::app.admin.datagrids.warehouse.seller_name'),
            'closure'    => function ($row) {
                return is_null($row->seller_name) ? "Souq Naif" : $row->seller_name;
            },
            'type' => 'string',
            'searchable' => true,
            'filterable' => true,
            'sortable' => true,
        ]);
        $this->addColumn([
            'index' => 'emirate',
            'label' => trans('delivery::app.admin.datagrids.warehouse.emirate'),
            'type' => 'string',
            'searchable' => true,
            'filterable' => true,
            'sortable' => true,
        ]);
        $this->addColumn([
            'index' => 'address',
            'label' => trans('delivery::app.admin.datagrids.warehouse.address'),
            'type' => 'string',
            'searchable' => true,
            'filterable' => true,
            'sortable' => true,
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
            'icon' => 'icon-edit',
            'title' => 'test',
            'method' => 'GET',
            'url' => function ($row) {
                return route('admin.delivery.warehouses.edit', $row->id);
            },
        ]);
    }
}
