<?php

namespace Scriptpage\Query\Filters;

use Illuminate\Contracts\Database\Query\Builder as IBuilder;

class CustomFilter extends BaseFilter
{
    function apply(string $expressions) {
        return $this->urlFilter->getBuilder();
    }

    function customApply(string $method, string $expressions)
    {
        $builder = $this->urlFilter->getBuilder();
        foreach ($this->parserExpression($expressions) as $expression) {
            // Conditions
            $values = $this->parserValues($expression);

            call_user_func_array([$this->urlFilter, $method], array_filter($values));
        }
        return $builder;
    }
}