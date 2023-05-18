<?php

namespace Scriptpage\Repository\Filters;

use Illuminate\Contracts\Database\Query\Builder;
use Scriptpage\Contracts\IRepository;

class TakeFilter extends BaseFilter
{
    function validate($value): bool
    {
        return true;
    }
    
    function apply(IRepository $repository, String $value): Builder
    {
        $repository->setTake((int)$value);
        return $repository->getBuilder();
    }
}