<?php

namespace Organon\Marketplace\DataGrids;

use Illuminate\Support\Facades\DB;
use Webkul\DataGrid\DataGrid;

class SellerCategoryDataGrid extends DataGrid
{


    public function prepareQueryBuilder()
    {
        $query = DB::table('seller_categories')->orderBy('seller_categories.created_at', 'DESC');
        $query->leftJoin('seller_categories as parents', 'seller_categories.parent_id', 'parents.id');
        $query->addSelect('seller_categories.name');
        $query->addSelect('parents.name as parent_name');
        $query->addSelect('seller_categories.id');

        $this->addFilter('name', 'seller_categories.name');
        $this->addFilter('parent_name', 'parents.name');

        return $query;
    }

    public function prepareColumns()
    {
        $this->addColumn([
            'index' => 'name',
            'label' => trans('marketplace::app.admin.seller_categories.index.datagrid.name'),
            'type' => 'string',
            'searchable' => true,
            'filterable' => false,
            'sortable' => false,
        ]);
        $this->addColumn([
            'index' => 'parent_name',
            'label' => trans('marketplace::app.admin.seller_categories.index.datagrid.parent'),
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
            'icon' => 'icon-edit',
            'title' => 'edit',
            'method' => 'GET',
            'url' => function ($row) {
                return route('admin.seller_categories.edit', ['id' => $row->id]);
            },
        ]);
    }
}
