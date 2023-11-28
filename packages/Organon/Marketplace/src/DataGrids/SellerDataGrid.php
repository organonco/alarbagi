<?php

namespace Organon\Marketplace\DataGrids;

use Illuminate\Support\Facades\DB;
use Webkul\DataGrid\DataGrid;

class SellerDataGrid extends DataGrid
{

    public function prepareQueryBuilder()
    {

        $query = DB::table('sellers')->orderBy('sellers.created_at', 'DESC');
        $query->join('admins', 'admins.seller_id', '=', 'sellers.id');

        $query->addSelect('sellers.name as shop_name');
        $query->addSelect('admins.email as email');
        $query->addSelect('sellers.id');

        return $query;
    }

    public function prepareColumns()
    {
        $this->addColumn([
            'index' => 'shop_name',
            'label' => trans('marketplace::app.admin.sellers.index.datagrid.shop-name'),
            'type' => 'string',
            'searchable' => true,
            'filterable' => false,
            'sortable' => false,
        ]);
        $this->addColumn([
            'index' => 'email',
            'label' => trans('marketplace::app.admin.sellers.index.datagrid.email'),
            'type' => 'string',
            'searchable' => true,
            'filterable' => false,
            'sortable' => false,
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
