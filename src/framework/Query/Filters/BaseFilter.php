<?php

namespace Scriptpage\Query\Filters;

use Scriptpage\Contracts\IUrlFilter;
use Illuminate\Contracts\Database\Query\Builder as IBuilder;
use Scriptpage\Query\UrlFilter;

abstract class BaseFilter implements IUrlFilter
{
    protected UrlFilter $urlFilter;

    function __construct(UrlFilter $urlFilter)
    {
        $this->urlFilter = $urlFilter;
    }

    /**
     * Parser expression by semicolons (;)
     * @param mixed $values
     * @return array<string>|bool
     */
    final protected function parserExpression(string $expressions)
    {
        return explode(';', $expressions);
    }

    /**
     * Splitting an expression into two parts separated by the character (:)
     * @param mixed $expression
     * @return array<string>|bool
     */
    final protected function parserParts(string $expression)
    {
        return explode(':', $expression);
    }

    /**
     * Splitting values by comma (,)
     * @param mixed $values
     * @return array<string>|bool
     */
    final protected function parserValues(string $values)
    {
        return explode(',', $values);
    }

    abstract function apply(String $values);

    // abstract protected function validate($value): bool;
}
