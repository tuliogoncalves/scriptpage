<?php

namespace Scriptpage\Repository\Filters;

use Illuminate\Contracts\Database\Query\Builder;
use Scriptpage\Contracts\IRepository;

class OrWhereFilter extends WhereFilter
{
    protected $boolean = 'or';

    function apply(IRepository $repository, string $expressions): Builder
    {
        parent::apply($repository, $expressions);
        return $this->builder;
    }
}
