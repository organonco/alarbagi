<?php

namespace Organon\Marketplace\Providers;

use Illuminate\Support\Facades\Event;
use Illuminate\Support\ServiceProvider;

class MarketplaceServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        $this->loadMigrationsFrom(__DIR__ . '/../Database/Migrations');

        $this->loadRoutesFrom(__DIR__ . '/../Http/admin-routes.php');

        $this->loadRoutesFrom(__DIR__ . '/../Http/shop-routes.php');

        $this->loadTranslationsFrom(__DIR__ . '/../Resources/lang', 'marketplace');

        $this->publishes([
            __DIR__ . '/../../publishable/assets' => public_path('themes/default/assets'),
        ], 'public');


        $this->publishes([
            __DIR__ . '/../Resources/views' => resource_path('views/vendor')
        ]);

        $this->loadViewsFrom(__DIR__ . '/../Resources/views', 'marketplace');

        Event::listen('bagisto.admin.layout.head', function ($viewRenderEventManager) {
            $viewRenderEventManager->addTemplate('marketplace::admin.layouts.style');
        });


        //Extending Models
        $this->app->concord->registerModel(\Webkul\User\Contracts\Admin::class, \Organon\Marketplace\Models\Admin::class);
        $this->app->concord->registerModel(\Webkul\Product\Contracts\Product::class, \Organon\Marketplace\Models\Product::class);
        $this->app->concord->registerModel(\Webkul\Sales\Contracts\Order::class, \Organon\Marketplace\Models\Order::class);
        $this->app->concord->registerModel(\Organon\Marketplace\Contracts\Seller::class, \Organon\Marketplace\Models\Seller::class);
        $this->app->concord->registerModel(\Webkul\Notification\Contracts\Notification::class, \Organon\Marketplace\Models\Notification::class);
    }

    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->registerConfig();
    }

    /**
     * Register package config.
     *
     * @return void
     */
    protected function registerConfig()
    {
        $this->mergeConfigFrom(
            dirname(__DIR__) . '/Config/acl.php', 'acl'
        );

        $this->mergeConfigFrom(
            dirname(__DIR__) . '/Config/admin-menu.php', 'menu.admin'
        );
    }
}