<?php

namespace Scriptpage\Repository\Filters;

use Illuminate\Contracts\Database\Query\Builder;
use Scriptpage\Contracts\IRepository;
use Scriptpage\Contracts\IUrlFilter;

class TakeFilter implements IUrlFilter
{
    function apply(IRepository $repository, String $value): Builder
    {
        $repository->setTake((int)$value);
        return $repository->getBuilder();
    }
}