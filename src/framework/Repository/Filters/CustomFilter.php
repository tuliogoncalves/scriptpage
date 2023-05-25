<?php

namespace Scriptpage\Repository\Filters;

use Illuminate\Contracts\Database\Query\Builder;
use Scriptpage\Contracts\IRepository;

class CustomFilter
{
    protected $operators = [
        'equal' => '=',
        'greater' => '>',
        'less' => '<',
        'less_or_equal' => '<=',
        'greater_or_equal' => '>=',
        'different' => '<>',
        'null_safe' => '<=>',
        'like' => 'like',
        'not_like' => 'not like',
        'in' => 'in',
        'not_in' => 'not_in',
        'between' => 'between',
        'not_between' => 'not_between'
    ];

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

    protected Builder $builder;

    function apply(IRepository $repository, string $expressions): Builder
    {
        $this->builder = $repository->getBuilder();
        foreach ($this->parserExpression($expressions) as $expression) {
            // Parts
            $parts = $this->parserParts($expression);
            $value = $parts[1] ?? '';

            // Conditions
            $_tmp = $this->parserValues($parts[0]);
            $column = $_tmp[0];
            $condition = $_tmp[1] ?? 'equal';
            $operator = $this->operators[$condition] ?? '=';

            // Method
            $method = $this->method[$condition];

            // Call mehthod when $column exists
            if (empty($column) == false)
                $this->builder = $this->$method($column, $operator, $value);
        }
        return $this->builder;
    }

    function where(string $column, string $operator, string $value): Builder
    {
        $builder = $this->builder;
        $value = str_replace('*', '%', $value);
        return $builder->where($column, $operator, $value, $this->boolean);
    }

    function whereIn(string $column, string $operator, string $value): Builder
    {
        $builder = $this->builder;
        $values = $this->parserValues($value);
        return $builder->whereIn($column, $values, $this->boolean);
    }
}