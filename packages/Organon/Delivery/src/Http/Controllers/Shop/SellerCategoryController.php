<?php

namespace Organon\Delivery\Http\Controllers\Shop;

use App\Banner;
use Illuminate\Routing\Controller;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Http\Request;
use Organon\Delivery\Models\Area;
use Organon\Marketplace\Models\Seller;
use Organon\Marketplace\Models\SellerCategory;

class SellerCategoryController extends Controller
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    public function view(Request $request, $areaId, $categoryId)
    {
        /** @var SellerCategory */
        $sellerCategory = SellerCategory::query()->findOrFail($categoryId);
        $area = Area::query()->isActive()->findOrFail($areaId);

        $sellers = Seller::query()->isActive()->area($area->id)->sellerCategory($categoryId)->get();
        
        $mobileBanners = Banner::transform(Banner::forSellerCategory($area->id, $sellerCategory->id)->mobile()->get());
        $desktopBanners = Banner::transform(Banner::forSellerCategory($area->id, $sellerCategory->id)->desktop()->get());

        return view('shop::sellerCategories.view')->with(compact('sellerCategory', 'sellers', 'area', 'mobileBanners', 'desktopBanners'));
    }
}
