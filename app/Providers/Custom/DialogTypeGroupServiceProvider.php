<?php

namespace App\Providers\Custom;

use Illuminate\Support\ServiceProvider;
use App\Services\Realizations\DialogTypeGroupService;

class DialogTypeGroupServiceProvider extends ServiceProvider
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
        $this->app->bind('App\Services\Interfaces\IDialogTypeGroupService', function() {
            return new DialogTypeGroupService();
        });
    }
}
