<?php

namespace Scriptpage\Query\Filters;

class PaginateFilter extends BaseFilter
{
   function apply(string $value)
    {
        $this->urlFilter->setPaginate($value=='true');
        return $this->urlFilter->getBuilder();
    }
}