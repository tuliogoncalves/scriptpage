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
        // AboutCommand::add('Scriptpage', fn () => ['Version' => Framework::VERSION]);
    }
}