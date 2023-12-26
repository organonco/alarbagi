<?php

namespace Organon\Marketplace\DataGrids;

use Illuminate\Support\Facades\DB;
use Organon\Marketplace\Enums\SellerStatusEnum;
use Organon\Marketplace\Models\Seller;
use Webkul\DataGrid\DataGrid;

class SellerDataGrid extends DataGrid
{

    public function prepareQueryBuilder()
    {

        $query = DB::table('sellers')->orderBy('sellers.created_at', 'DESC');
        $query->join('admins', 'admins.seller_id', '=', 'sellers.id');
        
        $query->addSelect('sellers.id');
        $query->addSelect('sellers.name as shop_name');
        $query->addSelect('admins.email as email');
        $query->addSelect('sellers.status as status');
        $query->addSelect('sellers.slug as slug');

        $this->addFilter('shop_name', 'sellers.name');
        $this->addFilter('status', 'sellers.status');
        $this->addFilter('slug', 'sellers.slug');
        $this->addFilter('email', 'admins.email');

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

        $statusOptions = [];
        foreach (SellerStatusEnum::cases() as $case)
            $statusOptions[] = [
                'label' => trans('marketplace::app.seller.statuses.' . $case->name . '.label'),
                'value' => $case->value,
            ];

        $this->addColumn([
            'index' => 'status',
            'label' => trans('marketplace::app.admin.sellers.index.datagrid.status'),
            'type' => 'dropdown',
            'options' => [
                'type' => 'basic',
                'params' => [
                    'options' => $statusOptions
                ],
            ],
            'searchable' => true,
            'filterable' => true,
            'sortable' => true,
            'closure' => fn($row) => '<p class="label-' . trans('marketplace::app.seller.statuses.' . Seller::getStatusFromValue($row->status)->name . '.class') . '">' . trans('marketplace::app.seller.statuses.' . Seller::getStatusFromValue($row->status)->name . '.label') . '</p>',
        ]);

        $this->addColumn([
            'index' => 'slug',
            'label' => trans('marketplace::app.admin.sellers.index.datagrid.slug'),
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
                return route('admin.sales.sellers.view', $row->id);
            },
        ]);
    }
}
