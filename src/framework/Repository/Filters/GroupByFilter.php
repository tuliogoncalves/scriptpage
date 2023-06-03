<?php

namespace Scriptpage\Repository\Filters;

use Illuminate\Contracts\Database\Query\Builder;
use Scriptpage\Contracts\IRepository;

class GroupByFilter extends BaseFilter
{
    function apply(IRepository $repository, String $values): Builder
    {
        $builder = $repository->getBuilder();
        $expresions = $this->parserExpression($values);

        // Relations
        $groups = $this->parserValues($expresions[0]);
        
        return $builder->groupBy($groups);
    }
}