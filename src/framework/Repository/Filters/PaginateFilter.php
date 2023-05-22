<?php

namespace Scriptpage\Repository\Filters;

use Illuminate\Contracts\Database\Query\Builder;
use Scriptpage\Contracts\IRepository;

class PaginateFilter extends BaseFilter
{
   function apply(IRepository $repository, string $value): Builder
    {
        $repository->setPaginate($value=='true');
        return $repository->getBuilder();
    }
}