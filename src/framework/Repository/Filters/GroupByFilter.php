<?php

namespace Scriptpage\Repository\Filters;

use Scriptpage\Contracts\IRepository;

class GroupByFilter extends BaseFilter
{
    function apply(IRepository $repository, String $values)
    {
        $builder = $repository->getBuilder();
        $expresions = $this->parserExpression($values);

        // Relations
        $groups = $this->parserValues($expresions[0]);
        
        return $builder->groupBy($groups);
    }
}