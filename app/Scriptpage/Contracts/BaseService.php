<?php

namespace App\Scriptpage\Contracts;

abstract class BaseService
implements IService
{

    /**
     * __construct
     *
     * @return BaseService
     */
    public function __construct()
    {
        $this->bootstrap();
        return $this;
    }

    /**
     * Custom init
     *
     * @return void
     */
    protected function bootstrap()
    {
    }
}
