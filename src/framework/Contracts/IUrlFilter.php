<?php

namespace Scriptpage\Contracts;

use Illuminate\Contracts\Database\Query\Builder as IBuilder;

interface IUrlFilter
{
    /**
     * apply
     *
     * @return void
     */
    function apply(String $values);
}
