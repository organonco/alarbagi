<?php

namespace Organon\Delivery\Http\Controllers\Shop;

use Illuminate\Routing\Controller;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Http\Request;
use Organon\Marketplace\Models\Seller;
use Organon\Marketplace\Models\SellerCategory;

class SellerCategoryController extends Controller
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    public function view(Request $request, $areaId, $categoryId)
    {
        /** @var SellerCategory */
        $sellerCategory = SellerCategory::query()->findOrFail($categoryId);
        if($sellerCategory->isParent()){
            $children = $sellerCategory->children()->get();
            return view('shop::sellerCategories.view')->with(compact('sellerCategory', 'children', 'areaId'));
        }
        else{
            $sellers = Seller::query()->isActive()->area($areaId)->sellerCategory($categoryId);
            return view('shop::sellerCategories.viewChild')->with(compact('sellerCategory', 'sellers'));
        }
    }
}
