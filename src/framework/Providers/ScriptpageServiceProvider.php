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

        // scriptpage-Jwt
        //----------------------
        $this->scriptpageJwt();

        // scriptpage-role
        //----------------------
        $this->scriptpageRole();

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

        // Userrequest
        $this->publishes(
            [
                __DIR__ . '/../Requests/UserRequest.php' =>  app_path('Http/Controllers/Requests/UserRequest.php')
            ],
            'scriptpage-install'
        );
    }

    private function scriptpageJwt()
    {
        // Controllers
        $this->publishes(
            [
                __DIR__ . '/../Controllers/AuthController.php' =>  app_path('Http/Controllers/AuthController.php')
            ],
            'scriptpage-jwt'
        );

        // Routes
        $this->publishes(
            [
                __DIR__ . '/../Routes/api/auth.route.php' => base_path('routes/_routes/api/auth.route.php')
            ],
            'scriptpage-jwt'
        );

        // trait
        $this->publishes(
            [
                __DIR__ . '/../Traits/traitUserJWT.php' =>  app_path('Traits/traitUserJWT.php')
            ],
            'scriptpage-jwt'
        );
    }

    private function scriptpageRole()
    {
        // Migrations
        $this->publishes(
            [
                __DIR__ . '/../Migrations/2021_11_09_201808_create_roles_table.php' =>
                base_path('database/migrations/2021_11_09_201808_create_roles_table.php')
            ],
            'scriptpage-role'
        );

        // Models
        $this->publishes(
            [
                __DIR__ . '/../Models/Role.php' =>  app_path('Models/Role.php')
            ],
            'scriptpage-role'
        );

        // Services
        $this->publishes(
            [
                __DIR__ . '/../Services/RolesService.php' =>  app_path('Services/RoleService.php')
            ],
            'scriptpage-role'
        );

        // Controllers
        $this->publishes(
            [
                __DIR__ . '/../Controllers/RoleController.php' =>  app_path('Http/Controllers/RoleController.php')
            ],
            'scriptpage-role'
        );

        // User JWT routes
        $this->publishes(
            [
                __DIR__ . '/../Routes/api/users-jwt.route.php' => base_path('routes/_routes/api/users-jwt.route.php')
            ],
            'scriptpage-role'
        );

        // trait
        $this->publishes(
            [
                __DIR__ . '/../Traits/traitUserJWT.php' =>  app_path('Traits/traitUserJWT.php')
            ],
            'scriptpage-role'
        );
    }
}
