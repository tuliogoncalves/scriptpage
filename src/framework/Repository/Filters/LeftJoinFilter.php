<?php

namespace Scriptpage\Repository\Filters;

use Illuminate\Contracts\Database\Query\Builder;
use Scriptpage\Contracts\IRepository;

class LeftJoinFilter extends JoinFilter
{
    protected string $type = "left";

    function apply(IRepository $repository, string $expressions): Builder
    {
        $builder = parent::apply($repository, $expressions);
        return $builder;
    }
}
