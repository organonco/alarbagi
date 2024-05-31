<?php

namespace Organon\Delivery\Http\Controllers\WarehouseAdmin;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Organon\Delivery\Models\Package;
use Organon\Marketplace\Traits\InteractsWithAuthenticatedAdmin;

class ViewPackageController extends Controller
{
    use InteractsWithAuthenticatedAdmin;

    public function __invoke(Request $request, $id)
    {
        $sellerId = $this->getAuthenticatedWarehouseAdmin()->getSellerId();
        $package = Package::findByHash($request->hash, $sellerId);
        if (!$package->isCurrentHolder($this->getAuthenticatedWarehouseAdmin()->warehouse))
            abort(404);
        return view('delivery::warehouse_admin.view-package')->with(compact('package'));
    }
}
