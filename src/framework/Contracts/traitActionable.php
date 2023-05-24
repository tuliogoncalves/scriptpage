<?php

namespace Scriptpage\Contracts;

trait traitActionable
{

    /**
     * make
     *
     * @return self
     */
    public static function make(): self
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
