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
        return view('marketplace::admin.sellers.index');
    }

    public function view($id)
    {
        $seller = $this->sellerRepository->find($id);
        return view('marketplace::admin.sellers.view')->with(['seller' => $seller]);
    }

    public function activate($id)
    {
        $this->sellerRepository->activate($id);
        return redirect(route('admin.sales.sellers.view', $id));
    }

    public function deactivate($id)
    {
        $this->sellerRepository->deactivate($id);
        return redirect(route('admin.sales.sellers.view', $id));
    }
    public function updateExpiryDate($id)
    {
        $this->sellerRepository->update(request()->only(['expiry_date']), $id);
        return redirect(route('admin.sales.sellers.view', $id));
    }
}
