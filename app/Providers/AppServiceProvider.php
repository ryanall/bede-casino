<?php

namespace BedeCasino\Providers;

use Illuminate\Support\ServiceProvider;
use BedeCasino\Repositories\CasinosEloquentRepository;
use BedeCasino\Repositories\Contracts\CasinoRespositoryInterface;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        // This has been bound to an interface as in future, if we want to use an third party
        // service to store our casino data i.e. Algolia, we can change the binding to new
        // such as CasinosAlgoliaRepository without any issues

        $this->app->bind(
            CasinoRespositoryInterface::class,
            CasinosEloquentRepository::class
        );
    }
}
