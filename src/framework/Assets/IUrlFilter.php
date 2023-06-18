<?php

namespace Scriptpage\Assets;
use Illuminate\Contracts\Database\Query\Builder;
use Scriptpage\Contracts\IRepository;

interface IUrlFilter
{
    /**
     * apply
     *
     * @return void
     */
    function apply(IRepository $repository, String $values): Builder;
}
