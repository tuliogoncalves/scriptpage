<?php

namespace Scriptpage\Repository\Filters;

use Illuminate\Contracts\Database\Query\Builder;
use Scriptpage\Contracts\IRepository;
use Scriptpage\Contracts\IUrlFilter;

abstract class BaseFilter implements IUrlFilter
{
    /**
     * Parser expression by semicolons (;)
     * @param mixed $values
     * @return array<string>|bool
     */
    final protected function parserExpression(string $expressions): array|bool
    {
        return explode(';', $expressions);
    }

    /**
     * Splitting value by (:)
     * @param mixed $expression
     * @return array<string>|bool
     */
    final protected function parserValue(string $expression): array|bool
    {
        return explode(':', $expression);
    }

    /**
     * Splitting values by comma (,)
     * @param mixed $values
     * @return array<string>|bool
     */
    final protected function parserValues(string $values): array|bool
    {
        return explode(',', $values);
    }
    
    abstract function apply(IRepository $repository, String $values): Builder;

    abstract protected function validate($value): bool;
}
