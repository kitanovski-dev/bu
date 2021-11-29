<?php

namespace App\Providers;

use App\App\Domain\Suppiers\OpenGDS\OpenGds;
use App\App\Domain\Suppiers\SupplierInterface;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
        $this->app->bind(
            'App\App\Domain\Suppiers\SupplierInterface',
            'App\App\Domain\Suppiers\OpenGDS\OpenGds'
        );
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        //

        // $this->app->singleton(SupplierInterface::class, function () {
        //     return OpenGds::class;
        // });
    }
}
