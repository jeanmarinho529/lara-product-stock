<?php

namespace App\Providers;

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
        $this->app->bind(
            'App\Repository\Contracts\StateRepositoryInterface',
            'App\Repository\Eloquent\StateRepository'
        );

        $this->app->bind(
            'App\Repository\Contracts\CategoryRepositoryInterface',
            'App\Repository\Eloquent\CategoryRepository'
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
    }
}
