<?php

namespace Scriptpage\Repository\Filters;

use Illuminate\Contracts\Database\Query\Builder;
use Scriptpage\Contracts\IRepository;

class SkipFilter extends BaseFilter
{   
    function apply(IRepository $repository, String $value): Builder
    {
        $offset = (int)$value;
        $repository->setSkip($offset);
        return $repository->getBuilder();
    }
}