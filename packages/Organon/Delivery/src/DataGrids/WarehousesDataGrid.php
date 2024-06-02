<?php

namespace Organon\Delivery\DataGrids;

use Illuminate\Support\Facades\DB;
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
            'label' => __("Warehouse Name"),
            'type' => 'string',
            'searchable' => true,
            'filterable' => true,
            'sortable' => true,
        ]);
        if (is_null($this->sellerId))
            $this->addColumn([
                'index' => 'seller_name',
                'label' => __("Warehouse Owner"),
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
            'label' => __("Emirate"),
            'type' => 'string',
            'searchable' => true,
            'filterable' => true,
            'sortable' => true,
        ]);
        $this->addColumn([
            'index' => 'address',
            'label' => __("Address"),
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