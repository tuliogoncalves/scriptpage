<?php

namespace Scriptpage\Repository\Filters;

use Illuminate\Contracts\Database\Query\Builder;
use Scriptpage\Contracts\IRepository;

class OrderByFilter extends BaseFilter
{
    function apply(IRepository $repository, string $expressions): Builder
    {
        $builder = $repository->getBuilder();

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