<?php

namespace Organon\Wadili\Providers;

use Illuminate\Support\Facades\Route;
use Illuminate\Support\ServiceProvider;

class WadiliServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
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
            dirname(__DIR__) . '/Config/carriers.php', 'carriers'
        );

        $this->mergeConfigFrom(
            dirname(__DIR__) . '/Config/wadili.php', 'wadili'
        );

        $this->mergeConfigFrom(
            dirname(__DIR__) . '/Config/system.php', 'core'
        );

        Route::middleware([])->group(__DIR__ . '/../Http/api.php');

        $this->loadTranslationsFrom(__DIR__ . '/../Resources/lang', 'shipping-wadili');
    }
}
