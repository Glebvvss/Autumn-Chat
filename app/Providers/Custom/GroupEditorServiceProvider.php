<?php

namespace App\Providers\Custom;

use Illuminate\Support\ServiceProvider;
use App\Services\Realizations\GroupEditor;

class GroupEditorServiceProvider extends ServiceProvider
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
        $this->app->bind('App\Services\Interfaces\GroupEditorService', function() {
            return new GroupEditor();
        });
    }
}