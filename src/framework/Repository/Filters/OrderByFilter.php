<?php

namespace Scriptpage\Repository\Filters;

use Scriptpage\Contracts\IRepository;

class OrderByFilter extends BaseFilter
{
    function apply(IRepository $repository, string $expressions)
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