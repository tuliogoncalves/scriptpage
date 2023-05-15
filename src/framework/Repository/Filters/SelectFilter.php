<?php

namespace Scriptpage\Repository\Filters;

use Scriptpage\Contracts\IRepository;
use Scriptpage\Contracts\IUrlFilter;

class SelectFilter implements IUrlFilter
{
    private function parser(string $values)
    {
        return explode(',', $values);
    }

    function apply(IRepository $repository, string $values)
    {
        $model = $repository->getModel();
        return $model->select($this->parser($values));
    }
}