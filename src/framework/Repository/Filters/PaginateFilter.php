<?php

namespace Scriptpage\Repository\Filters;

use Illuminate\Contracts\Database\Query\Builder;
use Scriptpage\Contracts\IRepository;

class PaginateFilter extends BaseFilter
{
    function validate($value): bool
    {
        return true;
    }

    function apply(IRepository $repository, string $value): Builder
    {
        $repository->setPaginate((bool) $value);
        return $repository->getBuilder();
    }
}