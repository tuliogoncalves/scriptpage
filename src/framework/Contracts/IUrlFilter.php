<?php

namespace Scriptpage\Contracts;
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
