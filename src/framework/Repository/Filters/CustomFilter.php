<?php

namespace Scriptpage\Repository\Filters;

use Scriptpage\Contracts\IRepository;

class CustomFilter extends BaseFilter
{
    function apply(IRepository $repository, string $expressions) {
        return $repository->getBuilder();
    }

    function customApply(IRepository $repository, string $method, string $expressions)
    {
        $builder = $repository->getBuilder();
        foreach ($this->parserExpression($expressions) as $expression) {
            // Conditions
            $values = $this->parserValues($expression);

            call_user_func_array([$repository, $method], array_filter($values));
        }
        return $builder;
    }
}