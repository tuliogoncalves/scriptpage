<?php

namespace Scriptpage\Repository\Filters;

use Scriptpage\Contracts\IRepository;

class TakeFilter extends BaseFilter
{   
    function apply(IRepository $repository, String $value)
    {
        $value = (int)$value;
        $builder = $repository->getBuilder();

        $repository->setTake((int)$value);
        return $builder;
    }
}