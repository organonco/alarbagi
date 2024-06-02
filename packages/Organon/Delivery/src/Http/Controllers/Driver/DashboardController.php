<?php

namespace Organon\Delivery\Http\Controllers\Driver;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Organon\Delivery\Enums\TripStatusEnum;
use Organon\Marketplace\Traits\InteractsWithAuthenticatedAdmin;

class DashboardController extends Controller
{
    use InteractsWithAuthenticatedAdmin;

    public function __invoke(Request $request)
    {
        $packages = $this->getAuthenticatedDriver()->packages;
        $tripsStatus = $request->status;
        if (is_null(TripStatusEnum::tryFrom($tripsStatus)))
            $tripsStatus = 'pending';
        $trips = $this->getAuthenticatedDriver()->trips()->where('status', $tripsStatus)->get();
        return view('delivery::driver.dashboard')->with(compact('packages', 'tripsStatus', 'trips'));
    }
}
