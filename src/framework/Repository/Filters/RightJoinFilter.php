<?php

namespace Scriptpage\Repository\Filters;

use Scriptpage\Contracts\IRepository;

class RightJoinFilter extends JoinFilter
{
    protected string $type = "right";

}
