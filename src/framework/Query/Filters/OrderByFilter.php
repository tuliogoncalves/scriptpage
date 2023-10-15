<?php

namespace Scriptpage\Query\Filters;

class OrderByFilter extends BaseFilter
{
    function apply(string $expressions)
    {
        $builder = $this->urlFilter->getBuilder();
        foreach ($this->parserExpression($expressions) as $expression) {
            $parts = $this->parserParts($expression);

            // orderBy
            $column = $parts[0] ?? '';
            $direction = $parts[1] ?? 'asc';

            if(empty($column)==false)
                $builder = $builder->OrderBy($column, $direction);
        }

        return $builder;
    }
}