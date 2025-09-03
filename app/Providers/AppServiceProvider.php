<?php

namespace App\Providers;

use App\Http\Controllers\NotificationController;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        // $this->app('Dingo\Api\Auth\Auth')->extend('basic', function ($app) {
        //     return new Dingo\Api\Auth\Provider\Basic($app['auth'], 'email');
        //  });
    
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}
