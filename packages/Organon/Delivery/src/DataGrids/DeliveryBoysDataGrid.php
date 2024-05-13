<?php

namespace Organon\Delivery\DataGrids;

use Illuminate\Support\Facades\DB;
use Webkul\DataGrid\DataGrid;

class DeliveryBoysDataGrid extends DataGrid
{

    public function __construct(private $sellerId = null)
    {
        if ($this->sellerId == null)
            $this->sellerId = auth('admin')->user()->getSellerId();
    }

    public function prepareQueryBuilder()
    {

        $query = DB::table('delivery_boys')->orderBy('delivery_boys.created_at', 'DESC');

        if (!is_null($this->sellerId))
            $query->where('seller_id', $this->sellerId);

        $query->leftJoin('sellers', 'sellers.id', '=', 'delivery_boys.seller_id');

        $query->addSelect('delivery_boys.id as id');
        $query->addSelect('sellers.name as seller_name');
        $query->addSelect('delivery_boys.name as name');
        $query->addSelect('delivery_boys.phone as phone');
        $query->addSelect('delivery_boys.email as email');

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
                return route('admin.delivery.delivery_boys.edit', $row->id);
            },
        ]);
    }
}
