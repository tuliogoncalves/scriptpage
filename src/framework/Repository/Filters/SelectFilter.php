<?php

namespace Scriptpage\Repository\Filters;

use Illuminate\Contracts\Database\Query\Builder;
use Scriptpage\Contracts\IRepository;

class SelectFilter extends BaseFilter
{
    function validate($value): bool
    {
        return true;
    }

    function apply(IRepository $repository, String $values): Builder
    {
        $builder = $repository->getBuilder();
        return $builder->select($this->parserValues($values));
    }
}