<?php

namespace App\Providers;


use Illuminate\Support\ServiceProvider;
use App\Extensions\SessionMaria;
use Illuminate\Support\Facades\Session;
use Illuminate\Contracts\Foundation\Application;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    protected $listen = [

    ];
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {

        Session::extend('mariadb', function (Application $app) {
            return new SessionMaria;

        });
    }
}
