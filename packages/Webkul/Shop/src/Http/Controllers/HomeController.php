<?php

namespace Webkul\Shop\Http\Controllers;

use App\Banner;
use Organon\Delivery\Models\Area;
use Webkul\Category\Repositories\CategoryRepository;
use Webkul\Shop\Repositories\ThemeCustomizationRepository;

class HomeController extends Controller
{
    /**
     * Using const variable for status
     */
    const STATUS = 1;
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(protected ThemeCustomizationRepository $themeCustomizationRepository, protected CategoryRepository $categoryRepository) {}

    /**
     * Loads the home page for the storefront.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        visitor()->visit();

        $customizations = $this->themeCustomizationRepository->orderBy('sort_order')->findWhere([
            'status'     => self::STATUS,
            'channel_id' => core()->getCurrentChannel()->id,
        ]);

        $categories = $this->categoryRepository->where('parent_id', '1')->get();
        $areas = Area::query()->isActive()->isVisible()->get();

        $desktopBanners = Banner::transform(Banner::main()->desktop()->get());
        $mobileBanners = Banner::transform(Banner::main()->mobile()->get());

        return view('shop::home.index', compact('customizations'))->with(['categories' => $categories, 'areas' => $areas, 'desktopBanners' => $desktopBanners, 'mobileBanners' => $mobileBanners]);
    }

    /**
     * Loads the home page for the storefront if something wrong.
     *
     * @return \Exception
     */
    public function notFound()
    {
        abort(404);
    }
}
