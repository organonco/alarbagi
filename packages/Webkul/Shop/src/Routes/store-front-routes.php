<?php

use App\Http\Controllers\FcmController;
use Illuminate\Support\Facades\Route;
use Organon\Delivery\Http\Controllers\Shop\AreaController;
use Organon\Delivery\Http\Controllers\Shop\OfferController;
use Organon\Delivery\Http\Controllers\Shop\SellerCategoryController;
use Webkul\Shop\Http\Controllers\CMS\PagePresenterController;
use Webkul\Shop\Http\Controllers\CompareController;
use Webkul\Shop\Http\Controllers\HomeController;
use Webkul\Shop\Http\Controllers\ProductController;
use Webkul\Shop\Http\Controllers\ProductsCategoriesProxyController;
use Webkul\Shop\Http\Controllers\SearchController;
use Webkul\Shop\Http\Controllers\SubscriptionController;

Route::group(['middleware' => ['locale', 'theme', 'currency']], function () {
    /**
     * CMS pages.
     */
    Route::get('page/{slug}', [PagePresenterController::class, 'presenter'])
        ->name('shop.cms.page')
        ->middleware('cacheResponse');

    /**
     * Fallback route.
     */
    Route::fallback(ProductsCategoriesProxyController::class . '@index')
        ->name('shop.product_or_category.index')
        ->middleware('cacheResponse');

    /**
     * Store front home.
     */
    Route::get('/', [HomeController::class, 'index'])
        ->name('shop.home.index')
        ->middleware('cacheResponse');

    /**
     * Store front search.
     */
    Route::get('search', [SearchController::class, 'index'])
        ->name('shop.search.index')
        ->middleware('cacheResponse');

    Route::post('search/upload', [SearchController::class, 'upload'])->name('shop.search.upload');

    /**
     * Subscription routes.
     */
    Route::controller(SubscriptionController::class)->group(function () {
        Route::post('subscription', 'store')->name('shop.subscription.store');

        Route::get('subscription/{token}', 'destroy')->name('shop.subscription.destroy');
    });

    /**
     * Compare products
     */
    Route::get('compare', [CompareController::class, 'index'])
        ->name('shop.compare.index')
        ->middleware('cacheResponse');

    /**
     * Downloadable products
     */
    Route::controller(ProductController::class)->group(function () {
        Route::get('downloadable/download-sample/{type}/{id}', 'downloadSample')->name('shop.downloadable.download_sample');

        Route::get('product/{id}/{attribute_id}', 'download')->defaults('_config', [
            'view' => 'shop.products.index',
        ])->name('shop.product.file.download');

        Route::get('products', 'index')->name('shop.products.index');
    });

    Route::get('area/{id}', [AreaController::class, 'view'])->name('area.view');
    Route::get('category/{areaId}/{sellerCategoryId}', [SellerCategoryController::class, 'view'])->name('seller-category.view');
    Route::get('offers', [OfferController::class, 'index'])->name('offer.index');

    Route::post('fcm', FcmController::class);
    
});
