<?php

namespace Organon\Delivery\Http\Controllers\Driver;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Organon\Delivery\Models\Package;
use Organon\Marketplace\Traits\InteractsWithAuthenticatedAdmin;

class ViewPackageController extends Controller
{
    use InteractsWithAuthenticatedAdmin;

    public function __invoke(Request $request, $id)
    {
        $package = Package::findByHash($request->hash, null);
        return view('delivery::driver.view-package')->with(compact('package'));
    }
}
