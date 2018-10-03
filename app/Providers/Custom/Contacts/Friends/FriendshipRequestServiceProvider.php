<?php

namespace App\Providers\Custom\Contacts\Friends;

use Illuminate\Support\ServiceProvider;
use App\Services\Realizations\Contacts\Friends\FriendshipRequest;

class FriendshipRequestServiceProvider extends ServiceProvider
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
        $this->app->bind('App\Services\Interfaces\Contacts\Friends\FriendshipRequest', function() {
            return new FriendshipRequest();
        });
    }
}