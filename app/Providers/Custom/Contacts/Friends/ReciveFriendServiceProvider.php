<?php 

namespace App\Providers\Custom\Contacts\Friends;

use Illuminate\Support\ServiceProvider;
use App\Services\Realizations\EloquentBased\Contacts\Friends\ReciveFriend;

class ReciveFriendServiceProvider extends ServiceProvider
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
        $this->app->bind('App\Services\Interfaces\Contacts\Friends\ReciveFriend', function() {
            return new ReciveFriend();
        });
    }
}