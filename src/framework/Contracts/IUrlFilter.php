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
    function apply(Builder $builder, String $values): Builder;
}
