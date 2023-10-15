<?php

namespace Scriptpage\Query\Filters;

class SkipFilter extends BaseFilter
{   
    function apply(String $value)
    {
        $offset = (int)$value;
        $this->urlFilter->setSkip($offset);
        return $this->urlFilter->getBuilder();
    }
}