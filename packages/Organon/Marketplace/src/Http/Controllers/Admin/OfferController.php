<?php

namespace Organon\Marketplace\Http\Controllers\Admin;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Organon\Marketplace\DataGrids\OfferDataGrid;

class OfferController extends Controller
{

    /**
     * @param Request $request
     */
    public function index(Request $request)
    {
        if (request()->ajax())
            return app(OfferDataGrid::class)->toJson();
        return view('marketplace::admin.offers.index');
    }

}
