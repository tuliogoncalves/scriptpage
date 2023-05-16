<?php

namespace Scriptpage\Repository\Filters;

use Illuminate\Contracts\Database\Query\Builder;
use Scriptpage\Contracts\IUrlFilter;

class WithFilter implements IUrlFilter
{
    private function parser(string $values)
    {
        return explode(',', $values);
    }

    function apply(Builder $builder, String $values): Builder
    {
        return $builder->with($this->parser($values));
    }
}