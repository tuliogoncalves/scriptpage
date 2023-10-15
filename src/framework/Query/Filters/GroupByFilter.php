<?php

namespace Scriptpage\Query\Filters;

class GroupByFilter extends BaseFilter
{
    function apply(String $values)
    {
        $builder = $this->urlFilter->getBuilder();
        $expresions = $this->parserExpression($values);

        // Relations
        $groups = $this->parserValues($expresions[0]);
        
        return $builder->groupBy($groups);
    }
}