<?php

namespace Scriptpage\Repository\Filters;

use Illuminate\Contracts\Database\Query\Builder;
use Scriptpage\Contracts\IUrlFilter;

class TakeFilter implements IUrlFilter
{
    function apply(Builder $builder, String $value): Builder
    {
        return $builder->take((int)$value);
    }
}