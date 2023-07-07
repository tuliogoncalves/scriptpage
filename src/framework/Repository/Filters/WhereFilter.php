<?php

namespace Scriptpage\Repository\Filters;

use Scriptpage\Contracts\IRepository;

class WhereFilter extends BaseFilter
{
    use traitOperators;

    protected $method = [
        'equal' => 'where',
        'greater' => 'where',
        'less' => 'where',
        'less_or_equal' => 'where',
        'greater_or_equal' => 'where',
        'different' => 'where',
        'null_safe' => 'where',
        'like' => 'where',
        'not_like' => 'where',
        'in' => 'whereIn',
        'not_in' => 'whereNotIn',
        'between' => 'whereBetween',
        'not_between' => 'whereNotBetween'
    ];

    protected $boolean = 'and';

    function where(string $column, string $operator, string $value)
    {
        $builder = $this->builder;
        $value = str_replace('*', '%', $value);
        return $builder->where($column, $operator, $value, $this->boolean);
    }

    function whereIn(string $column, string $operator, string $value)
    {
        $builder = $this->builder;
        $values = $this->parserValues($value);
        return $builder->whereIn($column, $values, $this->boolean);
    }

    function whereBetween(string $column, string $operator, string $value)
    {
        $builder = $this->builder;
        $values = $this->parserValues($value);
        return $builder->whereBetween($column, $values, $this->boolean);
    }

    function whereNotBetween(string $column, string $operator, string $value)
    {
        $builder = $this->builder;
        $values = $this->parserValues($value);
        return $builder->whereNotBetween($column, $values, $this->boolean);
    }
}