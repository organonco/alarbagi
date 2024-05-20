<?php

namespace Organon\Marketplace\Http\Controllers\Admin;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller;
use Organon\Delivery\Helpers\QRGeneratorHelper;
use Organon\Delivery\Models\Warehouse;
use Organon\Marketplace\DataGrids\SellerOrderDataGrid;
use Organon\Marketplace\Notifications\Repositories\SellerOrderRepository;
use Organon\Marketplace\Traits\InteractsWithAuthenticatedAdmin;

class SellerOrderController extends Controller
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests, InteractsWithAuthenticatedAdmin;

    /**
     * Contains route related configuration
     *
     * @var array
     */
    protected $_config;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(private readonly SellerOrderRepository $sellerOrderRepository)
    {
        $this->middleware('admin');

        $this->_config = request('_config');
    }

    /**
     * Display a listing of the seller orders.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        if (request()->ajax())
            return app(SellerOrderDataGrid::class, ['sellerId' => request()->seller_id])->toJson();
        return view('marketplace::admin.orders.index');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     * @return \Illuminate\View\View
     */
    public function edit($id)
    {
        return view('marketplace::admin.orders.view')->with([
            'order' => $this->sellerOrderRepository->findWhere(['order_id' => $id, 'seller_id' => auth('admin')->user()->getSellerId()])->firstOrFail(),
            'warehouses' => $this->getAuthenticatedSeller()->warehouses()->pluck('name', 'id'),
            'qr' => QRGeneratorHelper::test()
        ]);
    }


    /**
     * @param $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function approve($id)
    {
        $sellerOrder = $this->sellerOrderRepository->findWhere(['order_id' => $id, 'seller_id' => auth('admin')->user()->getSellerId()])->firstOrFail();
        $this->sellerOrderRepository->approve($sellerOrder);
        return redirect()->route('marketplace.admin.orders.view', ['order_id' => $id]);
    }


    /**
     * @param $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function cancel($id)
    {
        $sellerOrder = $this->sellerOrderRepository->findWhere(['order_id' => $id, 'seller_id' => auth('admin')->user()->getSellerId()])->firstOrFail();
        $this->sellerOrderRepository->cancel($sellerOrder);
        return redirect()->route('marketplace.admin.orders.view', ['order_id' => $id]);
    }


    /**
     * @param $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function ready($id)
    {
        request()->validate(['warehouse_id' => 'required']);
        $warehouse = Warehouse::forSeller($this->getAuthenticatedAdmin()->getSellerId())->findOrFail(request()->warehouse_id);
        $sellerOrder = $this->sellerOrderRepository->findWhere(['order_id' => $id, 'seller_id' => auth('admin')->user()->getSellerId()])->firstOrFail();
        $this->sellerOrderRepository->ready($sellerOrder);
        return redirect()->route('marketplace.admin.orders.view', ['order_id' => $id]);
    }
}
