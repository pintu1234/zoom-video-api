<?php

namespace Hcbszoom\Zoom;

use Illuminate\Support\ServiceProvider;

class ZoomServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->make('Hcbszoom\Zoom\ZoomController');
        $this->loadViewsFrom(__DIR__.'/views', 'zoom');
        $this->loadMigrationsFrom(__DIR__.'/migrations');
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
       include __DIR__.'/routes.php';
    }
}
