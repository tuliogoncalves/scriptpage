<?php

namespace Scriptpage\Repository\Filters;

use Scriptpage\Contracts\IRepository;

class PaginateFilter extends BaseFilter
{
   function apply(IRepository $repository, string $value)
    {
        $repository->setPaginate($value=='true');
        return $repository->getBuilder();
    }
}