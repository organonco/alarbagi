<?php

namespace Organon\Delivery\DataGrids;

use Illuminate\Support\Facades\DB;
use Webkul\DataGrid\DataGrid;

class WarehouseAdminsDataGrid extends DataGrid
{

    public function __construct(private $sellerId = null)
    {
        if ($this->sellerId == null)
            $this->sellerId = auth('admin')->user()->getSellerId();
    }

    public function prepareQueryBuilder()
    {

        $query = DB::table('warehouse_admins')->orderBy('warehouse_admins.created_at', 'DESC');

        if (!is_null($this->sellerId))
            $query->where('seller_id', $this->sellerId);

        $query->leftJoin('sellers', 'sellers.id', '=', 'warehouse_admins.seller_id');

        $query->addSelect('warehouse_admins.id as id');
        $query->addSelect('sellers.name as seller_name');
        $query->addSelect('warehouse_admins.name as name');
        $query->addSelect('warehouse_admins.phone as phone');
        $query->addSelect('warehouse_admins.email as email');

        return $query;
    }

    public function prepareColumns()
    {
        $this->addColumn([
            'index' => 'name',
            'label' => __('Name'),
            'type' => 'string',
            'searchable' => true,
            'filterable' => true,
            'sortable' => true,
        ]);
        if (is_null($this->sellerId))
            $this->addColumn([
                'index' => 'seller_name',
                'label' => __('Seller Name'),
                'closure'    => function ($row) {
                    return is_null($row->seller_name) ? "Souq Naif" : $row->seller_name;
                },
                'type' => 'string',
                'searchable' => true,
                'filterable' => true,
                'sortable' => true,
            ]);

        $this->addColumn([
            'index' => 'email',
            'label' => __('Email'),
            'type' => 'string',
            'searchable' => true,
            'filterable' => true,
            'sortable' => true,
        ]);

        $this->addColumn([
            'index' => 'phone',
            'label' => __('Phone'),
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
                return route('admin.delivery.warehouse_admins.edit', $row->id);
            },
        ]);
    }
}
