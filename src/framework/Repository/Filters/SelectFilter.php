<?php

namespace Scriptpage\Repository\Filters;

use Scriptpage\Contracts\IRepository;

class SelectFilter extends BaseFilter
{
    function apply(IRepository $repository, String $values)
    {
        $builder = $repository->getBuilder();
        return $builder->select($this->parserValues($values));
    }
}