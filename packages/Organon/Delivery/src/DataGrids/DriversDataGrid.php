<?php

namespace Organon\Delivery\DataGrids;

use Illuminate\Support\Facades\DB;
use Organon\Marketplace\Traits\InteractsWithAuthenticatedAdmin;
use Webkul\DataGrid\DataGrid;

class DriversDataGrid extends DataGrid
{

    use InteractsWithAuthenticatedAdmin;

    public function __construct(private $sellerId = null)
    {
        $this->sellerId = $this->getAuthenticatedAdmin()->getSellerId();
    }

    public function prepareQueryBuilder()
    {

        $query = DB::table('drivers')->orderBy('drivers.created_at', 'DESC');

        if (!is_null($this->sellerId))
            $query->where('seller_id', $this->sellerId);

        $query->leftJoin('sellers', 'sellers.id', '=', 'drivers.seller_id');

        $query->addSelect('drivers.id as id');
        $query->addSelect('sellers.name as seller_name');
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
                return route('admin.delivery.drivers.edit', $row->id);
            },
        ]);
    }
}
