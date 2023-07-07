<?php

namespace Scriptpage\Repository\Filters;

use Scriptpage\Contracts\IRepository;

class JoinFilter extends BaseFilter
{
    protected string $type = "inner";

    function apply(IRepository $repository, string $expressions)
    {
        $builder = $repository->getBuilder();
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
