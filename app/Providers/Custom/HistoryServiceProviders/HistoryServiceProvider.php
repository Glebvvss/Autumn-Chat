<?php

namespace App\Providers\Custom\HistoryServiceProviders;

use Illuminate\Support\ServiceProvider;
use App\Services\Realizations\HistoryServices\HistoryService;

class HistoryServiceProvider extends ServiceProvider
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
        $this->app->bind('App\Services\Interfaces\IHistoryServices\IHistoryService', function() {
            return new HistoryService();
        });
    }
}