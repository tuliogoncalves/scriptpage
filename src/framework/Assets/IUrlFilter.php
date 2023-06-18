<?php

namespace Scriptpage\Assets;
use Illuminate\Contracts\Database\Query\Builder;

interface IUrlFilter
{
    /**
     * apply
     *
     * @return void
     */
    function apply(IRepository $repository, String $values): Builder;
}
