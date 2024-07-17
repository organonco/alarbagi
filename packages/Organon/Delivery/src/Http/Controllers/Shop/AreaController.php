<?php

namespace Organon\Delivery\Http\Controllers\Shop;

use Illuminate\Routing\Controller;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Http\Request;
use Organon\Delivery\Models\Area;

class AreaController extends Controller
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    public function view(Request $request, $areaId)
    {
        $area = Area::query()->isActive()->findOrFail($areaId);
        return view('shop::areas.view')->with(['area' => $area]);
    }
}
