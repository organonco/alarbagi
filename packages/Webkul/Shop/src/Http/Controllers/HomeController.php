<?php

namespace Webkul\Shop\Http\Controllers;

use Organon\Delivery\Models\Area;
use Webkul\Category\Repositories\CategoryRepository;
use Webkul\CMS\Models\CmsPage;
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
    public function __construct(protected ThemeCustomizationRepository $themeCustomizationRepository, protected CategoryRepository $categoryRepository)
    {
    }

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
        $areas = Area::query()->isActive()->get();
        $pages = CmsPage::whereHas('translations')->get();
        return view('shop::home.index', compact('customizations'))->with(['categories' => $categories, 'areas' => $areas, 'pages' => $pages]);
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
