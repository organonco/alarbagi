<?php

namespace Organon\Delivery\Http\Controllers\Shipping;

use Illuminate\Routing\Controller;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Http\Request;
use Organon\Marketplace\Traits\InteractsWithAuthenticatedAdmin;

class SettingsController extends Controller
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;
    use InteractsWithAuthenticatedAdmin;

    public function index()
    {
        $model = $this->getAuthenticatedShippingCompany();
        return view('delivery::shipping.settings.index', ['per_order_price' => $model->per_order_price, 'per_product_price' => $model->per_product_price]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'per_order_price' => 'required|numeric',
            'per_product_price' => 'required|numeric',
        ]);
        $model = $this->getAuthenticatedShippingCompany();
        $model->update($request->only([
            'per_order_price', 'per_product_price'
        ]));
        return redirect()->route('shipping.settings');
    }

}
