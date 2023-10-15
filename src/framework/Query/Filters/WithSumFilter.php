<?php

namespace Scriptpage\Query\Filters;

class WithSumFilter extends BaseFilter
{
    function apply(string $expressions)
    {
        $builder = $this->urlFilter->getBuilder();

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