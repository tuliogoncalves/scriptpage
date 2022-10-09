<?php

namespace App\Scriptpage\Repository;

use App\Scriptpage\Contracts\IService;

abstract class BaseService
implements IService
{

    /**
     * __construct
     *
     * @return BaseService
     */
    function __construct()
    {
        $this->init();
        return $this;
    }

    /**
     * Custom init
     *
     */
    function init()
    {
    }
}
