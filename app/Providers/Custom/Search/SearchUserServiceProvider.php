<?php

namespace App\Providers\Custom\Search;

use Illuminate\Support\ServiceProvider;
use App\Services\Realizations\Search\SearchUser;

class SearchUserServiceProvider extends ServiceProvider
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
        $this->app->bind('App\Services\Interfaces\Search\SearchUser', function() {
            return new SearchUser();
        });
    }
}