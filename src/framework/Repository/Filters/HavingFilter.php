<?php

namespace Scriptpage\Repository\Filters;

use Scriptpage\Contracts\IRepository;

class HavingFilter extends BaseFilter
{
    use traitOperators;

    protected $method = [
        'equal' => 'having',
        'greater' => 'having',
        'less' => 'having',
        'less_or_equal' => 'having',
        'greater_or_equal' => 'having',
        'different' => 'having',
        'null_safe' => 'having',
        'like' => 'having',
        'not_like' => 'having',
        'in' => 'havingBetween', // ignore, not exists 'in'
        'not_in' => 'havingNotBetween', // ignore, not exists 'not_int'
        'between' => 'havingBetween',
        'not_between' => 'havingNotBetween'
    ];

    protected $boolean = 'and';

    function having(string $column, string $operator, string $value)
    {
        $builder = $this->builder;
        $value = str_replace('*', '%', $value);
        return $builder->having($column, $operator, $value, $this->boolean);
    }

    function havingBetween(string $column, string $operator, string $value)
    {
        $builder = $this->builder;
        $values = $this->parserValues($value);
        return $builder->havingBetween($column, $values, $this->boolean);
    }

    function havingNotBetween(string $column, string $operator, string $value)
    {
        $builder = $this->builder;
        $values = $this->parserValues($value);
        return $builder->havingBetween($column, $values, $this->boolean, true);
    }
}