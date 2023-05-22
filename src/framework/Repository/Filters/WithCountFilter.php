<?php

namespace Scriptpage\Repository\Filters;

use Illuminate\Contracts\Database\Query\Builder;
use Scriptpage\Contracts\IRepository;

class WithCountFilter extends BaseFilter
{
    function apply(IRepository $repository, String $values): Builder
    {
        $builder = $repository->getBuilder();

        // Relations
        $relations = $this->parserValues($values);
        
        return $builder->withCount($relations);
    }
}