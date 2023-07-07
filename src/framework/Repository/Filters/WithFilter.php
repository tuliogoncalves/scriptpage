<?php

namespace Scriptpage\Repository\Filters;

use Scriptpage\Contracts\IRepository;

class WithFilter extends BaseFilter
{
    function apply(IRepository $repository, String $values)
    {
        $builder = $repository->getBuilder();

        // Relations
        $relations = $this->parserValues($values);
        
        return $builder->with($relations);
    }
}