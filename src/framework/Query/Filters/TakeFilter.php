<?php

namespace Scriptpage\Query\Filters;

class TakeFilter extends BaseFilter
{   
    function apply(String $value)
    {
        $value = (int)$value;
        $this->urlFilter->setTake((int)$value);
        return $this->urlFilter->getBuilder();
    }
}