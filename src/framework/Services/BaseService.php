<?php

namespace App\Scriptpage\Services;

use App\Scriptpage\Contracts\IService;
use App\Scriptpage\Contracts\traitActionable;

abstract class BaseService implements IService
{
    use traitActionable;
}
