<?php

namespace Scriptpage\Repository\Filters;

use Illuminate\Contracts\Database\Query\Builder;
use Scriptpage\Contracts\IRepository;
use Scriptpage\Contracts\IUrlFilter;

class PaginateFilter implements IUrlFilter
{
    function apply(IRepository $repository, String $value): Builder
    {
        $repository->setPaginate((bool)$value);
        return $repository->getBuilder();
    }
}