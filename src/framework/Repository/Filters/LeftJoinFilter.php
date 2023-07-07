<?php

namespace Scriptpage\Repository\Filters;

use Scriptpage\Contracts\IRepository;

class LeftJoinFilter extends JoinFilter
{
    protected string $type = "left";

}
