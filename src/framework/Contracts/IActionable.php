<?php

namespace Scriptpage\Contracts;

interface IActionable
{
    /**
     * make
     *
     * @return this
     */
    static function make();

    /**
     * run
     *
     * @see static::handle()
     */
    static function run();
    
    /**
     * go
     *
     * @return mixed
     */
    function go();
}
