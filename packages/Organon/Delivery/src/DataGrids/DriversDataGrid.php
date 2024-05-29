<?php

namespace Organon\Delivery\DataGrids;

use Illuminate\Support\Facades\DB;
use Organon\Marketplace\Traits\InteractsWithAuthenticatedAdmin;
use Webkul\DataGrid\DataGrid;

class DriversDataGrid extends DataGrid
{

    use InteractsWithAuthenticatedAdmin;

    public function __construct()
    {
    }

    public function prepareQueryBuilder()
    {

        $query = DB::table('drivers')->orderBy('drivers.created_at', 'DESC');

        $query->addSelect('drivers.id as id');
        $query->addSelect('drivers.name as name');
        $query->addSelect('drivers.phone as phone');
        $query->addSelect('drivers.email as email');

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
                return route('admin.delivery.drivers.edit', $row->id);
            },
        ]);
    }
}
