<?php

namespace Scriptpage\Assets;

use Scriptpage\Contracts\IRepository;

interface IUrlFilter
{
    /**
     * apply
     *
     * @return void
     */
    function apply(IRepository $repository, String $values);
}
