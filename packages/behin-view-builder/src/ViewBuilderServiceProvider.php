<?php

namespace ViewBuilder;

use Illuminate\Support\ServiceProvider;

class ViewBuilderServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->mergeConfigFrom(__DIR__ . '/config/view_builder_config.php', 'view_builder_config');
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        $this->publishes([
            __DIR__ . '/config/view_builder_config.php' => config_path('view_builder_config.php')
        ]);
        $this->loadMigrationsFrom(__DIR__ . '/Migrations');
        $this->loadRoutesFrom(__DIR__ . '/routes/web.php');
        $this->loadViewsFrom(__DIR__. '/Views', 'view-builder');

    }
}
