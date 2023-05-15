<?php

namespace Scriptpage\Contracts;

interface IUrlFilter
{
    /**
     * apply
     *
     * @return void
     */
    function apply(IRepository $repository, String $values);
}
