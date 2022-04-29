<?php

namespace Raosys\Fees;

use Illuminate\Support\ServiceProvider;

class FeeServiceProvider extends ServiceProvider
{

    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        $this->loadRoutesFrom(__DIR__ . '/routes/web.php');
        $this->loadViewsFrom(__DIR__ . '/resources/views', 'fees');
        $this->loadMigrationsFrom(__DIR__ . '/database/migrations');
        $this->publishes([
            __DIR__ . '/resources/assets/' => public_path('vendor\raosys\fees'),
            __DIR__ . '/config/fees.php' => config_path('fees.php'),
        ], 'fees');
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        $this->mergeConfigFrom(__DIR__ . '/config/fees.php', 'fees');
        // // $this->app->bind('fees', function ($app) {
        // //     return new Fees;
        // // });
    }
}
