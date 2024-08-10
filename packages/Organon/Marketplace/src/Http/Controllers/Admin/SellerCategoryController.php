<?php

namespace Organon\Marketplace\Http\Controllers\Admin;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Validation\Rule;
use Organon\Marketplace\DataGrids\OfferDataGrid;
use Organon\Marketplace\DataGrids\SellerCategoryDataGrid;
use Organon\Marketplace\Models\Offer;
use Organon\Marketplace\Models\SellerCategory;
use Organon\Marketplace\Repositories\OfferRepository;
use Organon\Marketplace\Repositories\SellerCategoryRepository;
use Organon\Marketplace\Traits\InteractsWithAuthenticatedAdmin;

class SellerCategoryController extends Controller
{

    use InteractsWithAuthenticatedAdmin;

    public function __construct(private SellerCategoryRepository $sellerCategoryRepository)
    {
    }
    /**
     * @param Request $request
     * @return mixed
     */
    public function index(Request $request)
    {
        if (request()->ajax())
            return app(SellerCategoryDataGrid::class)->toJson();
        return view('marketplace::admin.seller_categories.index');
    }

    /**
     * @return \Illuminate\Contracts\View\View|\Illuminate\Contracts\View\Factory
     */
    public function create()
    {
        return view('marketplace::admin.seller_categories.create', ['categories' => SellerCategory::where('parent_id', null)->pluck('name', 'id')]);
    }

    /**
     * @param Request $request
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|max:500',
            'parent_id' => 'required',
			'sort' => 'required|numeric',
        ]);
        $data = $request->all();
        $data['parent_id'] = $data['parent_id'] == 0 ? null : $data['parent_id'];
        $this->sellerCategoryRepository->createSellerCategory($data);
        return redirect()->route('admin.seller_categories.index');
    }

    public function edit(Request $request, $id)
    {
        $model = SellerCategory::findOrFail($id);
        return view('marketplace::admin.seller_categories.edit', ['categories' => SellerCategory::where('parent_id', null)->pluck('name', 'id'), 'model' => $model]);
    }

    public function update(Request $request, $id)
    {
        $model = SellerCategory::findOrFail($id);

        $request->validate([
            'name' => 'required|max:500',
            'parent_id' => ['required', Rule::notIn([$id])],
			'sort' => 'required|numeric',
        ]);
        
        $data = $request->all();
        $data['parent_id'] = $data['parent_id'] == 0 ? null : $data['parent_id'];

        $this->sellerCategoryRepository->updateSellerCategory($model, $data);
        return redirect()->route('admin.seller_categories.index');
    }
}
