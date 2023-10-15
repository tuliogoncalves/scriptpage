<?php

namespace Scriptpage\Query\Filters;

class WithFilter extends BaseFilter
{
    function apply(String $values)
    {
        $builder = $this->urlFilter->getBuilder();

        // Relations
        $relations = $this->parserValues($values);
        
        return $builder->with($relations);
    }
}
