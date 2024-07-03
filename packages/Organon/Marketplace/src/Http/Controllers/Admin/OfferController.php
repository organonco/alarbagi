<?php

namespace Organon\Marketplace\Http\Controllers\Admin;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Organon\Marketplace\DataGrids\OfferDataGrid;
use Organon\Marketplace\Models\Offer;
use Organon\Marketplace\Repositories\OfferRepository;
use Organon\Marketplace\Traits\InteractsWithAuthenticatedAdmin;

class OfferController extends Controller
{

    use InteractsWithAuthenticatedAdmin;

    public function __construct(private OfferRepository $offerRepository)
    {
    }
    /**
     * @param Request $request
     * @return mixed
     */
    public function index(Request $request)
    {
        if (request()->ajax())
            return app(OfferDataGrid::class, ['sellerId' => $this->getAuthenticatedAdmin()->getSellerId()])->toJson();
        return view('marketplace::admin.offers.index');
    }

    /**
     * @return \Illuminate\Contracts\View\View|\Illuminate\Contracts\View\Factory
     */
    public function create()
    {
        return view('marketplace::admin.offers.create');
    }

    /**
     * @return void
     */
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required_without_all:post,image',
            'post' => 'required_without_all:title,image',
            'image' => 'required_without_all:post,title',
            'status' => 'sometimes|in:1',
        ]);

        $data = request()->all();
        $data['status'] = (bool)request()->input('status');
        $data['seller_id'] = $this->getAuthenticatedAdmin()->getSellerId();

        $this->offerRepository->createOffer($data);

        return redirect()->route('admin.offers.index');
    }


    public function edit($id)
    {
        $model = Offer::query()->forSeller($this->getAuthenticatedAdmin()->getSellerId())->findOrFail($id);
        return view('marketplace::admin.offers.edit', ['model' => $model]);
    }

    public function update(Request $request, $id)
    {
        $model = Offer::query()->forSeller($this->getAuthenticatedAdmin()->getSellerId())->findOrFail($id);

        $request->validate([
            'title' => 'required_without_all:post,image',
            'post' => 'required_without_all:title,image',
            'image' => 'required_without_all:post,title',
            'status' => 'sometimes|in:1',
        ]);

        $data = request()->all();
        $data['status'] = (bool)request()->input('status');

        $this->offerRepository->updateOffer($model, $data);
        return redirect()->route('admin.offers.index');
    }

    public function preview($id)
    {
        $model = Offer::query()->forSeller($this->getAuthenticatedAdmin()->getSellerId())->findOrFail($id);
        return view('marketplace::admin.offers.preview', ['model' => $model]);
    }
}
