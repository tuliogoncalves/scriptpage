<?php

namespace Scriptpage\Repository\Filters;

use Illuminate\Contracts\Database\Query\Builder;
use Scriptpage\Assets\IUrlFilter;
use Scriptpage\Contracts\IRepository;

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
     * Splitting an expression into two parts separated by the character (:)
     * @param mixed $expression
     * @return array<string>|bool
     */
    final protected function parserParts(string $expression): array|bool
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

    // abstract protected function validate($value): bool;
}
