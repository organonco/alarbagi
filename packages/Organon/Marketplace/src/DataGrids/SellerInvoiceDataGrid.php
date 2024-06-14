<?php

namespace Organon\Marketplace\DataGrids;

use Illuminate\Support\Facades\DB;
use Organon\Marketplace\Enums\SellerInvoiceStatusEnum;
use Organon\Marketplace\Traits\InteractsWithAuthenticatedAdmin;
use Webkul\DataGrid\DataGrid;

class SellerInvoiceDataGrid extends DataGrid
{

    use InteractsWithAuthenticatedAdmin;
    public function prepareQueryBuilder()
    {
        $query = DB::table('seller_invoices')->orderBy('seller_invoices.created_at', 'DESC');

        if($this->getAuthenticatedAdmin()->isSeller())
            $query->where('seller_id', $this->getAuthenticatedAdmin()->getSellerId())->where('seller_invoices.status', '!=', SellerInvoiceStatusEnum::DRAFT->value);

        $query->join('sellers', 'sellers.id', '=', 'seller_invoices.seller_id');

        $query->addSelect('seller_invoices.id as id');
        $query->addSelect('total as total');
        $query->addSelect('sellers.name as seller_name');
        $query->addSelect('seller_invoices.created_at as created_at');
        $query->addSelect('seller_invoices.status as status');

        $this->addFilter('seller_name', 'sellers.name');
        $this->addFilter('status', 'seller_invoices.status');
        $this->addFilter('total', 'seller_invoices.total');
        $this->addFilter('created_at', 'seller_invoices.created_at');

        return $query;
    }


    public function prepareColumns()
    {
        $this->addColumn([
            'index' => 'seller_name',
            'label' => 'التاجر',
            'type' => 'text',
            'searchable' => true,
            'sortable' => true,
            'filterable' => true,
        ]);
        $this->addColumn([
            'index' => 'total',
            'label' => 'المجموع',
            'type' => 'number',
            'searchable' => true,
            'sortable' => true,
            'filterable' => true,
        ]);
        $this->addColumn([
            'index' => 'status',
            'label' => 'حالة الفاتورة',
            'type' => 'text',
            'searchable' => true,
            'sortable' => true,
            'filterable' => true,
            'closure' => fn($row) => '<p class="label-' . trans('marketplace::app.seller-invoice.statuses.' . SellerInvoiceStatusEnum::tryFrom($row->status)->name . '.class') . '">' . trans('marketplace::app.seller-invoice.statuses.' . SellerInvoiceStatusEnum::tryFrom($row->status)->name . '.label') . '</p>',
        ]);
        $this->addColumn([
            'index' => 'created_at',
            'label' => 'تاريخ الإنشاء',
            'type' => 'text',
            'closure' => fn($row) => (new \DateTime($row->created_at))->format('d/m/Y'),
            'searchable' => true,
            'sortable' => true,
            'filterable' => true,
        ]);
    }

    public function prepareActions()
    {
        $this->addAction([
            'icon' => 'icon-view',
            'title' => 'test',
            'method' => 'GET',
            'url' => function ($row) {
                return route('admin.sales.sellers.invoice.view', $row->id);
            },
        ]);
    }
}