<?php

namespace Organon\Delivery\DataGrids;

use Illuminate\Support\Facades\DB;
use Webkul\DataGrid\DataGrid;

class ShippingCompanyDataGrid extends DataGrid
{

    public function prepareQueryBuilder()
    {
        $query = DB::table('shipping_companies')->orderBy('shipping_companies.created_at', 'DESC');
        $query->addSelect('id');
        $query->addSelect('name');
        $query->addSelect('info');
        $query->addSelect('is_active');
        $query->addSelect('username');
        return $query;
    }

    public function prepareColumns()
    {
        $this->addColumn([
            'index' => 'name',
            'label' => trans('delivery::app.shipping-company.attributes.name'),
            'type' => 'string',
            'searchable' => true,
            'filterable' => false,
            'sortable' => false,
        ]);
        
        $this->addColumn([
            'index' => 'name',
            'label' => trans('delivery::app.shipping-company.attributes.username'),
            'type' => 'string',
            'searchable' => true,
            'filterable' => false,
            'sortable' => false,
        ]);
        
        $this->addColumn([
            'index' => 'info',
            'label' => trans('delivery::app.shipping-company.attributes.info'),
            'type' => 'string',
            'searchable' => true,
            'filterable' => false,
            'sortable' => true,
        ]);

        $this->addColumn([
            'index' => 'is_active',
            'label' => trans('delivery::app.shipping-company.attributes.is_active'),
            'type' => 'string',
            'searchable' => true,
            'filterable' => false,
            'sortable' => true,
            'closure' => fn($row) => trans('delivery::app.shipping-company.is_active')[$row->is_active],
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
                return route('admin.delivery.shipping-company.edit', $row->id);
            },
        ]);
    }
}
