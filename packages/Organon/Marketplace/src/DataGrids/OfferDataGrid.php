<?php

namespace Organon\Marketplace\DataGrids;

use Illuminate\Support\Facades\DB;
use Webkul\DataGrid\DataGrid;

class OfferDataGrid extends DataGrid
{


    public function __construct(private ?int $sellerId)
    {
    }
    public function prepareQueryBuilder()
    {
        $query = DB::table('offers')->orderBy('offers.created_at', 'DESC');
        if (!is_null($this->sellerId))
            $query->where('seller_id', $this->sellerId);

        $query->addSelect('title');
        $query->addSelect('post');
        $query->addSelect('status');
        $query->addSelect('image_url');
        $query->addSelect('id');
        $query->addSelect(DB::raw(' IF(created_at < DATE(NOW()) - INTERVAL 7 DAY, 1, 0) as expired'));

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
            'closure'    => function ($value) {
                return $value->status ? "فعال" : "غير فعال";
            },
            'searchable' => false,
            'filterable' => true,
            'sortable' => false,
        ]);

        $this->addColumn([
            'index' => 'image_url',
            'label' => trans('marketplace::app.admin.offers.index.datagrid.image'),
            'type' => 'string',
            'closure'    => function ($value) {
                return "<img style='height: 80px; width: auto;' src='" . $value->image_url . "'/>";
            },
            'searchable' => false,
            'filterable' => false,
            'sortable' => false,
        ]);

        $this->addColumn([
            'index' => 'expired',
            'label' => trans('marketplace::app.admin.offers.index.datagrid.expired'),
            'type' => 'string',
            'searchable' => false,
            'filterable' => false,
            'sortable' => false,
            'closure'    => function ($value) {
                return $value->expired == 1 ? "نعم" : 'لا';
            },
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
                return route('admin.offers.edit', ['id' => $row->id]);
            },
        ]);
        $this->addAction([
            'icon' => 'icon-view',
            'title' => 'preview',
            'method' => 'GET',
            'url' => function ($row) {
                return route('admin.offers.preview', ['id' => $row->id]);
            },
        ]);
    }
}
