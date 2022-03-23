<?php

namespace App\Scriptpage\Core;

use App\Scriptpage\Contracts\ICore;
use App\Scriptpage\Contracts\ICrud;
use App\Scriptpage\Contracts\IRepository;

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
