<?php

namespace BaleBot;

use Illuminate\Support\ServiceProvider;

class BaleBotProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->mergeConfigFrom(__DIR__ . '/config/bale_bot_config.php', 'bale_bot_config');
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        $this->publishes([
            __DIR__ . '/config/bale_bot_config.php' => config_path('bale_bot_config.php')
        ]);
        $this->loadMigrationsFrom(__DIR__ . '/Migrations');
        $this->loadRoutesFrom(__DIR__ . '/routes/web.php');
    }
}
