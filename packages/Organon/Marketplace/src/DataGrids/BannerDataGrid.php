<?php

namespace Organon\Marketplace\DataGrids;

use App\Banner;
use Illuminate\Support\Facades\DB;
use Webkul\DataGrid\DataGrid;

class BannerDataGrid extends DataGrid
{


    public function prepareQueryBuilder()
    {
        $query = DB::table('banners')->orderBy('banners.created_at', 'DESC');
        $query->leftJoin('seller_categories as seller_categories', 'banners.seller_category_id', 'seller_categories.id');
        $query->leftJoin('areas as areas', 'banners.area_id', 'areas.id');

        $query->addSelect('banners.id');
        $query->addSelect('banners.is_mobile');
        $query->addSelect('seller_categories.name as seller_category');
        $query->addSelect('areas.name as area');

        return $query;
    }

    public function prepareColumns()
    {
        $this->addColumn([
            'index' => 'is_mobile',
            'label' => "موبايل؟",
            'type' => 'bool',
            'searchable' => true,
            'filterable' => false,
            'sortable' => false,
            'closure' => fn($row) => $row->is_mobile ? "نعم" : "لا",
        ]);
        $this->addColumn([
            "index" => "type",
            "label" => "نوع البنر",
            "type" => "string",
            'searchable' => false,
            'filterable' => false,
            'sortable' => false,
            'closure' => fn($row) => !$row->area && !$row->seller_category ? "رئيسي" : (!$row->seller_category ? "منطقة" : "تصنيف"),
        ]);
        $this->addColumn([
            "index" => "area",
            "label" => "المنطقة",
            "type" => "string",
            'searchable' => false,
            'filterable' => false,
            'sortable' => false,
        ]);
        $this->addColumn([
            "index" => "seller_category",
            "label" => "التصنيف",
            "type" => "string",
            'searchable' => false,
            'filterable' => false,
            'sortable' => false,
        ]);
        $this->addColumn([
            "index" => "banner",
            "label" => "البنر",
            "type" => "string",
            'searchable' => false,
            'filterable' => false,
            'sortable' => false,
            'closure' => fn($row) => '<img class="min-h-[65px] min-w-[65px] max-h-[65px] rounded-[4px]" src="' . Banner::find($row->id)->getBannerUrl() . '"/>'
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
                if(!$row->area && !$row->seller_category)
                    return route('admin.banners.edit.main', ['id' => $row->id]);
                elseif(!$row->seller_category)
                    return route('admin.banners.edit.area', ['id' => $row->id]);
                else
                    return route('admin.banners.edit.category', ['id' => $row->id]);
            },
        ]);

        $this->addAction([
            'icon' => 'icon-delete',
            'title' => 'edit',
            'method' => 'DELETE',
            'url' => function ($row) {
                return route('admin.banners.delete', ['id' => $row->id]);
            },
        ]);
    }
}
