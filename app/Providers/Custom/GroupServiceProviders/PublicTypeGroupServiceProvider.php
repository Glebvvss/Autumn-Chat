<?php

namespace App\Providers\Custom\GroupServiceProviders;

use Illuminate\Support\ServiceProvider;
use App\Services\Realizations\GroupServices\PublicTypeGroupService;

class PublicTypeGroupServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind('App\Services\Interfaces\IGroupServices\IPublicTypeGroupService', function() {
            return new PublicTypeGroupService();
        });
    }
}