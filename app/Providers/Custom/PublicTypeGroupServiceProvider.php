<?php

namespace App\Providers\Custom;

use Illuminate\Support\ServiceProvider;
use App\Services\Realizations\PublicTypeGroupService;

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
        $this->app->bind('App\Services\Interfaces\IPublicTypeGroupService', function() {
            return new PublicTypeGroupService();
        });
    }
}