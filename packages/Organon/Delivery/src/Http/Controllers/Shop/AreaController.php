<?php

namespace Organon\Delivery\Http\Controllers\Shop;

use Illuminate\Routing\Controller;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Http\Request;
use Organon\Delivery\Models\Area;
use Organon\Marketplace\Models\SellerCategory;

class AreaController extends Controller
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    public function view(Request $request, $areaId)
    {
        $area = Area::query()->isActive()->findOrFail($areaId);
        $categories = SellerCategory::query()->main()->get();
        return view('shop::areas.view')->with(compact('area', 'categories'));
    }
}
