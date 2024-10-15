<?php

namespace Organon\Marketplace\Http\Controllers\Admin;

use App\Banner;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Validation\Rule;
use Organon\Delivery\Models\Area;
use Organon\Marketplace\DataGrids\BannerDataGrid;
use Organon\Marketplace\DataGrids\SellerCategoryDataGrid;
use Organon\Marketplace\Models\SellerCategory;
use Organon\Marketplace\Repositories\SellerCategoryRepository;
use Organon\Marketplace\Traits\InteractsWithAuthenticatedAdmin;

class BannerController extends Controller
{

    use InteractsWithAuthenticatedAdmin;

    public function __construct() {}

    public function index()
    {
        if (request()->ajax())
            return app(BannerDataGrid::class)->toJson();
        return view('marketplace::admin.banner.index');
    }


    public function createMain()
    {
        return view('marketplace::admin.banner.create.main');
    }

    public function createArea()
    {
        return view('marketplace::admin.banner.create.area', ['areas' => Area::all()->pluck('name', 'id')]);
    }

    public function createCategory()
    {
        return view('marketplace::admin.banner.create.category', ['areas' => Area::all()->pluck('name', 'id'), 'sellerCategories' => SellerCategory::all()->pluck('name', 'id')]);
    }

    public function storeMain(Request $request)
    {
        $request->validate(['banner' => 'required']);
        /** @var Banner */
        $banner = Banner::create(['is_mobile' => $request->is_mobile ? 1 : 0]);
        $banner->addBanner($request);
        return redirect(route('admin.banners.index'));
    }

    public function storeArea(Request $request)
    {
        $request->validate(['banner' => 'required', 'area_id' => 'required']);
        /** @var Banner */
        $banner = Banner::create(['is_mobile' => $request->is_mobile ? 1 : 0, 'area_id' => $request->area_id]);
        $banner->addBanner($request);
        return redirect(route('admin.banners.index'));
    }

    public function storeCategory(Request $request)
    {
        $request->validate(['banner' => 'required', 'area_id' => 'required', 'seller_category_id' => 'required']);
        /** @var Banner */
        $banner = Banner::create(['is_mobile' => $request->is_mobile ? 1 : 0, 'area_id' => $request->area_id, 'seller_category_id' => $request->seller_category_id]);
        $banner->addBanner($request);
        return redirect(route('admin.banners.index'));
    }


    public function updateMain(Request $request, $id)
    {
        $request->validate(['banner' => 'required']);
        /** @var Banner */
        $banner = Banner::find($id);
        $banner->update(['is_mobile' => $request->is_mobile ? 1 : 0]);
        $banner->updateBanner($request);
        return redirect(route('admin.banners.index'));
    }

    public function updateArea(Request $request, $id)
    {
        $request->validate(['banner' => 'required', 'area_id' => 'required']);
        /** @var Banner */
        $banner = Banner::find($id);
        $banner->update(['is_mobile' => $request->is_mobile ? 1 : 0, 'area_id' => $request->area_id]);
        $banner->updateBanner($request);
        return redirect(route('admin.banners.index'));
    }

    public function updateCategory(Request $request, $id)
    {
        $request->validate(['banner' => 'required', 'area_id' => 'required', 'seller_category_id' => 'required']);
        /** @var Banner */
        $banner = Banner::find($id);
        $banner->update(['is_mobile' => $request->is_mobile ? 1 : 0, 'area_id' => $request->area_id, 'seller_category_id' => $request->seller_category_id]);
        $banner->updateBanner($request);
        return redirect(route('admin.banners.index'));
    }

    public function editMain($id)
    {
        $banner = Banner::find($id);
        return view('marketplace::admin.banner.edit.main', ['banner' => $banner]);
    }

    public function editArea($id)
    {
        $banner = Banner::find($id);
        return view('marketplace::admin.banner.edit.area', ['banner' => $banner, 'areas' => Area::all()->pluck('name', 'id')]);
    }

    public function editCategory($id)
    {
        $banner = Banner::find($id);
        return view('marketplace::admin.banner.edit.category', ['banner' => $banner, 'areas' => Area::all()->pluck('name', 'id'), 'sellerCategories' => SellerCategory::all()->pluck('name', 'id')]);
    }

    public function destroy($id)
    {
        $banner = Banner::find($id);
        $banner->delete();
    }
}
