<?php

namespace Scriptpage\Repository\Filters;

use Scriptpage\Contracts\IRepository;

class SkipFilter extends BaseFilter
{   
    function apply(IRepository $repository, String $value)
    {
        $offset = (int)$value;
        $repository->setSkip($offset);
        return $repository->getBuilder();
    }
}