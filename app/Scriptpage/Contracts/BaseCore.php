<?php

namespace App\Scriptpage\Core;

use App\Scriptpage\Contracts\ICore;

abstract class BaseCore
implements ICore
{

    /**
     * __construct
     *
     * @param  Illuminate\Http\Request $request
     * @return App\Scriptpage\BaseController
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
