<?php

namespace Organon\Marketplace\DataGrids;

use Illuminate\Support\Facades\DB;
use Webkul\DataGrid\DataGrid;

class OfferDataGrid extends DataGrid
{

    public function prepareQueryBuilder()
    {

        $query = DB::table('offers')->orderBy('offers.created_at', 'DESC');
        $query->addSelect('title');
        $query->addSelect('post');
        $query->addSelect('status');

        return $query;
    }

    public function prepareColumns()
    {
        $this->addColumn([
            'index' => 'title',
            'label' => trans('marketplace::app.admin.offers.index.datagrid.title'),
            'type' => 'string',
            'searchable' => true,
            'filterable' => false,
            'sortable' => false,
        ]);

        $this->addColumn([
            'index' => 'post',
            'label' => trans('marketplace::app.admin.offers.index.datagrid.post'),
            'type' => 'string',
            'searchable' => true,
            'filterable' => false,
            'sortable' => false,
        ]);

        $this->addColumn([
            'index' => 'status',
            'label' => trans('marketplace::app.admin.offers.index.datagrid.status'),
            'type' => 'boolean',
            'searchable' => false,
            'filterable' => true,
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
        // $this->addAction([
        //     'icon' => 'icon-view',
        //     'title' => 'test',
        //     'method' => 'GET',
        //     'url' => function ($row) {
        //         return route('admin.sales.sellers.view', $row->id);
        //     },
        // ]);
    }
}
