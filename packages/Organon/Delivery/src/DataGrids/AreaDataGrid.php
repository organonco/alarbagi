<?php

namespace Organon\Delivery\DataGrids;

use Illuminate\Support\Facades\DB;
use Webkul\DataGrid\DataGrid;

class AreaDataGrid extends DataGrid
{

    public function prepareQueryBuilder()
    {
        $query = DB::table('areas')->orderBy('areas.created_at', 'DESC');
        $query->addSelect('id');
        $query->addSelect('name');
        $query->addSelect('info');
        $query->addSelect('is_active');
        $query->addSelect('is_external');
        return $query;
    }

    public function prepareColumns()
    {
        $this->addColumn([
            'index' => 'name',
            'label' => trans('delivery::app.area.attributes.name'),
            'type' => 'string',
            'searchable' => true,
            'filterable' => false,
            'sortable' => false,
        ]);

        $this->addColumn([
            'index' => 'info',
            'label' => trans('delivery::app.area.attributes.info'),
            'type' => 'string',
            'searchable' => true,
            'filterable' => false,
            'sortable' => true,
        ]);

        $this->addColumn([
            'index' => 'is_active',
            'label' => trans('delivery::app.area.attributes.is_active'),
            'type' => 'string',
            'searchable' => true,
            'filterable' => false,
            'sortable' => true,
            'closure' => fn($row) => trans('delivery::app.area.is_active')[$row->is_active],
        ]);

        $this->addColumn([
            'index' => 'is_external',
            'label' => trans('delivery::app.area.attributes.is_external'),
            'type' => 'string',
            'searchable' => true,
            'filterable' => false,
            'sortable' => true,
            'closure' => fn($row) => trans('delivery::app.area.is_active')[$row->is_external],
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
                return route('admin.delivery.area.edit', $row->id);
            },
        ]);
    }
}
