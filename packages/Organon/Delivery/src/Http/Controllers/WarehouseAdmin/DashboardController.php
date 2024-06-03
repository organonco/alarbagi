<?php

namespace Organon\Delivery\Http\Controllers\WarehouseAdmin;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Organon\Delivery\Enums\TripStatusEnum;
use Organon\Marketplace\Traits\InteractsWithAuthenticatedAdmin;

class DashboardController extends Controller
{
    use InteractsWithAuthenticatedAdmin;

    public function __invoke(Request $request)
    {
        $packages = $this->getAuthenticatedWarehouseAdmin()->getPackages();
        $trips = $this->getAuthenticatedWarehouseAdmin()->warehouse->trips()->whereNot("status", TripStatusEnum::DONE)->get();
        return view('delivery::warehouse_admin.dashboard')->with(compact('packages', 'trips'));
    }
}
