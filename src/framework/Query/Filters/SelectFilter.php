<?php

namespace Scriptpage\Query\Filters;

class SelectFilter extends BaseFilter
{
    function apply(String $values)
    {
        $builder = $this->urlFilter->getBuilder();
        return $builder->select($this->parserValues($values));
    }
}