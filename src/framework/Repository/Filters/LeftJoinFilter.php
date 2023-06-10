<?php

namespace Scriptpage\Repository\Filters;

use Illuminate\Contracts\Database\Query\Builder;
use Scriptpage\Contracts\IRepository;

class LeftJoinFilter extends JoinFilter
{
    protected string $type = "left";

}
