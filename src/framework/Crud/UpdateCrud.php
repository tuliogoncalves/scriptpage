<?php

namespace Scriptpage\Crud;

use Illuminate\Database\Eloquent\Model;

abstract class UpdateCrud
{
    protected Model $model;

    function __construct(Model $model)
    {
        $this->model = $model;
    }
}
