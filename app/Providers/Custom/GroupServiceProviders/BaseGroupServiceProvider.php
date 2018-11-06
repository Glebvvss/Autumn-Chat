<?php

namespace App\Providers\Custom\GroupServiceProviders;

use Illuminate\Support\ServiceProvider;
use App\Services\Realizations\GroupServices\BaseGroupService;

class BaseGroupServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind('App\Services\Interfaces\IGroupServices\IBaseGroupService', function() {
            return new BaseGroupService();
        });
    }
}