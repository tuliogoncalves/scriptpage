<?php

namespace Scriptpage\Repository\Filters;

use Illuminate\Contracts\Database\Query\Builder;
use Scriptpage\Contracts\IRepository;

class JoinFilter extends BaseFilter
{
    function apply(IRepository $repository, String $expression): Builder
    {
        $builder = $repository->getBuilder();

        // Parts
        $parts = $this->parserParts($expression);
        $table = $parts[0] ?? '';
        $columns = $this->parserValues($parts[1]);

        // Columns
        $column1 = $columns[0] ?? '';
        $column2 = $columns[1] ?? '';

        $builder = $builder->join($table, $column1, '=', $column2);
        return $builder;
    }
}