<?php

namespace Organon\Delivery\Http\Controllers\Driver;

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
        return view('delivery::driver.add-package');
    }

    public function store(Request $request)
    {
        $request->validate([
            'hash' => 'required',
        ]);
        $hash = ltrim($request->hash, '#');
        $package = Package::findByHash($hash, null);
        $this->packageRepository->addTransaction($package, $this->getAuthenticatedDriver());
    }
}
