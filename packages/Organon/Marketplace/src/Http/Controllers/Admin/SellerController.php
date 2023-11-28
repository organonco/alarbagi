<?php

namespace Organon\Marketplace\Http\Controllers\Admin;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller;
use Organon\Marketplace\DataGrids\SellerDataGrid;
use Organon\Marketplace\Repositories\SellerRepository;

class SellerController extends Controller
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

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
    public function __construct(private readonly SellerRepository $sellerRepository)
    {
        $this->middleware('admin');

        $this->_config = request('_config');
    }

    public function index()
    {
        if (request()->ajax())
            return app(SellerDataGrid::class)->toJson();
        return view($this->_config['view']);
    }

    public function edit($id)
    {
//        return view($this->_config['view'])->with([
//            'order' => $this->sellerOrderRepository->findWhere(['order_id' => $id, 'seller_id' => auth('admin')->user()->getSellerId()])->firstOrFail()
//        ]);
    }
}
