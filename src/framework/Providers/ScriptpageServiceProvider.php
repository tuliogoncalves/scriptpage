<?php

namespace Scriptpage\Providers;


use Illuminate\Foundation\Console\AboutCommand;
use Illuminate\Support\ServiceProvider;
use Scriptpage\Framework;

class ScriptpageServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        // scriptpage-install
        //----------------------

        //helpers.php
        $this->publishes([__DIR__.'/../helpers.php' => app_path('./helpers.php')], 'scriptpage-install');

        // Routes
        $this->publishes([__DIR__.'/../Routes/api/users.route.php' => 
            base_path('routes/_routes/api/users.route.php')], 'scriptpage-install'
        );

        // Routes
        $this->publishes([__DIR__.'/../Routes/web/home.route.php' => 
            base_path('routes/_routes/web/home.route.php')], 'scriptpage-install'
        );

        // BaseResponses
        $this->publishes(
            [
                __DIR__.'/../Traits/traitBaseResponse.php' =>  app_path('Traits/traitBaseResponse.php')
            ], 
            'scriptpage-install'
        );
        
        // UserController
        $this->publishes(
            [
                __DIR__.'/../Controllers/UserController.php' =>  app_path('Http/Controllers/UserController.php')
            ], 
            'scriptpage-install'
        );
        // AboutCommand::add('Scriptpage', fn () => ['Version' => Framework::VERSION]);

    }
}