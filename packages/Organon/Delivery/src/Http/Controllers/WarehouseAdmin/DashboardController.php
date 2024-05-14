<?php

namespace Organon\Delivery\Http\Controllers\WarehouseAdmin;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;


class DashboardController extends Controller
{
    public function __invoke(Request $request)
    {
        return view('delivery::warehouse_admin.dashboard');
    }
}
