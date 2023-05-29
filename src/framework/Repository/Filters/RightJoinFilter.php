<?php

namespace Scriptpage\Repository\Filters;

use Illuminate\Contracts\Database\Query\Builder;
use Scriptpage\Contracts\IRepository;

class RightJoinFilter extends JoinFilter
{
    protected string $type = "right";

    function apply(IRepository $repository, string $expressions): Builder
    {
        $builder = parent::apply($repository, $expressions);
        return $builder;
    }
}
