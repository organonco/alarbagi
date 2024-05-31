<?php

namespace Organon\Delivery\Http\Controllers\Admin;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Organon\Delivery\Models\Package;
use Organon\Marketplace\Traits\InteractsWithAuthenticatedAdmin;


class PackageController extends Controller
{
    use InteractsWithAuthenticatedAdmin;

    public function view($hash)
    {
        $package = Package::findByHash($hash, $this->getAuthenticatedAdmin()->getSellerId());
        return view('marketplace::admin.package.view', compact('package'));
    }
}
