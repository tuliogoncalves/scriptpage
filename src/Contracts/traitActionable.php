<?php

namespace App\Scriptpage\Contracts;

trait traitActionable
{

    /**
     * make
     *
     * @return this
     */
    public static function make()
    {
        return app(static::class);
    }

    /**
     * run
     *
     * @see static::handle()
     */
    public static function run()
    {
        return static::make()->handle();
    }

    function go() {
        return $this->handle();
    }
}
