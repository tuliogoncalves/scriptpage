<?php

namespace Scriptpage\Query\Filters;

class JoinFilter extends BaseFilter
{
    protected string $type = "inner";

    function apply(string $expressions)
    {
        $builder = $this->urlFilter->getBuilder();
        foreach ($this->parserExpression($expressions) as $expression) {
            // Parts
            $parts = $this->parserParts($expression);
            $table = $parts[0] ?? '';
            $columns = $this->parserValues($parts[1]);

            // Columns
            $column1 = $columns[0] ?? '';
            $column2 = $columns[1] ?? '';

            $builder = $builder->join($table, $column1, '=', $column2, $this->type);
        }
        return $builder;
    }
}
