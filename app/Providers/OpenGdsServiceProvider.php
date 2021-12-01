<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class OpenGdsServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(
            'App\App\Domain\Suppiers\SupplierInterface',
            'App\App\Domain\Suppiers\OpenGDS\OpenGds'
        );
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
