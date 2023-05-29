<?php

namespace Scriptpage\Repository\Filters;

use Illuminate\Contracts\Database\Query\Builder;
use Scriptpage\Contracts\IRepository;

class CustomFilter extends BaseFilter
{
    function apply(IRepository $repository, string $expressions): Builder {
        return $repository->getBuilder();
    }

    function customApply(IRepository $repository, string $method, string $expressions): Builder
    {
        $builder = $repository->getBuilder();
        foreach ($this->parserExpression($expressions) as $expression) {
            // Conditions
            $values = $this->parserValues($expression);

            // Parts
            // $parts = $this->parserParts($expression);
            // $value = $parts[1] ?? '';

            call_user_func_array([$repository, $method], array_filter($values));
        }
        return $builder;
    }
}