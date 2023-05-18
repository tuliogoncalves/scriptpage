<?php

namespace Scriptpage\Repository\Filters;

use Illuminate\Contracts\Database\Query\Builder;
use Scriptpage\Contracts\IRepository;

class WithFilter extends BaseFilter
{
    function validate($value): bool
    {
        return true;
    }

    function apply(IRepository $repository, String $expressions): Builder
    {
        $builder = $repository->getBuilder();
        foreach ($this->parserExpression($expressions) as $expression) {
            $builder->with($this->parser($values));
        }
        return $builder;
    }
}