<?php

namespace Scriptpage\Repository\Filters;

use Illuminate\Contracts\Database\Query\Builder;
use Scriptpage\Contracts\IRepository;
use Scriptpage\Contracts\IUrlFilter;

class WithFilter implements IUrlFilter
{
    private function parser(string $values)
    {
        return explode(',', $values);
    }

    function apply(IRepository $repository, String $values): Builder
    {
        $builder = $repository->getBuilder();
        return $builder->with($this->parser($values));
    }
}