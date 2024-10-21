<?php

namespace Organon\Delivery\Http\Controllers\Shop;

use App\Banner;
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
        $categories = SellerCategory::query()->main()->get()->sortBy('sort');

        $mobileBanners = Banner::transform(Banner::forArea($area->id)->mobile()->get());
        $desktopBanners = Banner::transform(Banner::forArea($area->id)->desktop()->get());

        return view('shop::areas.view')->with(compact('area', 'categories', 'mobileBanners', 'desktopBanners'));
    }
}
