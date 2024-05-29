<?php

namespace Organon\Delivery\Http\Controllers\WarehouseAdmin;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Organon\Delivery\Models\Package;
use Organon\Delivery\Repositories\PackageRepository;
use Organon\Marketplace\Traits\InteractsWithAuthenticatedAdmin;

class AddPackageController extends Controller
{
    use InteractsWithAuthenticatedAdmin;

    public function __construct(private PackageRepository $packageRepository)
    {
    }
    public function create()
    {
        return view('delivery::warehouse_admin.add-package');
    }

    public function store(Request $request)
    {
        $request->validate([
            'hash' => 'required',
        ]);
        $sellerId = $this->getAuthenticatedWarehouseAdmin()->getSeller()->id;
        $package = Package::findByHash($request->hash, $sellerId);
        $this->packageRepository->addTransaction($package, $this->getAuthenticatedWarehouseAdmin()->warehouse);
    }
}
