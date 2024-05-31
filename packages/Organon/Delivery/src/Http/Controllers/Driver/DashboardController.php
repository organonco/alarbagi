<?php

namespace Organon\Delivery\Http\Controllers\Driver;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Organon\Marketplace\Traits\InteractsWithAuthenticatedAdmin;

class DashboardController extends Controller
{
    use InteractsWithAuthenticatedAdmin;

    public function __invoke(Request $request)
    {
        $packages = $this->getAuthenticatedDriver()->packages;
        return view('delivery::driver.dashboard')->with(compact('packages'));
    }
}
