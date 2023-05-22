<?php

namespace Scriptpage\Repository\Filters;

use Illuminate\Contracts\Database\Query\Builder;
use Scriptpage\Contracts\IRepository;

class WithSumFilter extends BaseFilter
{
    function apply(IRepository $repository, string $expressions): Builder
    {
        $builder = $repository->getBuilder();

        foreach ($this->parserExpression($expressions) as $expression) {
            $parts = $this->parserParts($expression);

            // withSum
            $relation = $parts[0] ?? '';
            $column = $parts[1] ?? '';

            if(empty($relation)== false and empty($column)==false)
                $builder = $builder->withSum($relation,$column);
        }

        return $builder;
    }
}