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
        $this->scriptpageInstall();

        // scriptpage-install
        //----------------------
        $this->scriptpageJwt();

        // AboutCommand::add('Scriptpage', fn () => ['Version' => Framework::VERSION]);

    }

    private function scriptpageInstall()
    {
        //helpers.php
        $this->publishes(
            [
                __DIR__ . '/../helpers.php' => app_path('./helpers.php')
            ],
            'scriptpage-install'
        );

        // Routes
        $this->publishes(
            [
                __DIR__ . '/../Routes/api/users.route.php' => base_path('routes/_routes/api/users.route.php')
            ],
            'scriptpage-install'
        );

        // Routes
        $this->publishes(
            [
                __DIR__ . '/../Routes/web/home.route.php' => base_path('routes/_routes/web/home.route.php')
            ],
            'scriptpage-install'
        );

        // BaseResponses
        $this->publishes(
            [
                __DIR__ . '/../Traits/traitBaseResponse.php' =>  app_path('Traits/traitBaseResponse.php')
            ],
            'scriptpage-install'
        );

        // UserController
        $this->publishes(
            [
                __DIR__ . '/../Controllers/UserController.php' =>  app_path('Http/Controllers/UserController.php')
            ],
            'scriptpage-install'
        );
    }

    private function scriptpageJwt()
    {
        // Routes
        $this->publishes(
            [
                __DIR__ . '/../Routes/api/users-jwt.route.php' => base_path('routes/_routes/api/users-jwt.route.php')
            ],
            'scriptpage-jwt'
        );

        // traitUserJWT
        $this->publishes(
            [
                __DIR__ . '/../Traits/traitUserJWT.php' =>  app_path('Traits/traitUserJWT.php')
            ],
            'scriptpage-jwt'
        );

        // Models\Role
        $this->publishes(
            [
                __DIR__ . '/../Models/Role.php' =>  app_path('Models/Role.php')
            ],
            'scriptpage-jwt'
        );

        // Controllers\AuthController.php
        $this->publishes(
            [
                __DIR__ . '/../Controllers/AuthController.php' =>  app_path('Controllers/AuthController.php')
            ],
            'scriptpage-jwt'
        );
    }
}
