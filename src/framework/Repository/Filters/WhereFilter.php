<?php

namespace Scriptpage\Repository\Filters;

use Illuminate\Contracts\Database\Query\Builder;
use Scriptpage\Contracts\IRepository;

class WhereFilter extends BaseFilter
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

    protected $filters = [
        'default' => 'where',
        'in' => 'whereIn',
        'not_in' => 'whereNotIn',
        'between' => 'whereBetween',
        'not_between' => 'whereNotBetween'
    ];

    protected $boolean = 'and';

    protected $builder;

    function validate($value): bool
    {
        return true;
    }

    function apply(IRepository $repository, string $expressions): Builder
    {
        $this->builder = $repository->getBuilder();
        foreach ($this->parserExpression($expressions) as $expression) {
            // Value
            $_tmp = $this->parserValue($expression);
            $value = $_tmp[1] ?? '';

            // Conditions
            $_tmp = $this->parserValues($_tmp[0]);
            $column = $_tmp[0];
            $condition = $_tmp[1] ?? 'equal';
            $operator = $this->operators[$condition] ?? '=';

            $filter = 'default';
            if (in_array($condition, $this->filters)) {
                $filter = $condition;
            }

            $method = $this->filters[$filter];

            $this->$method($column, $operator, $value, $this->boolean);
        }
        return $this->builder;
    }

    function where($column, $operator, $value, $boolean): Builder
    {
        dd($column, $operator, $value, $boolean);
        $builder = $this->builder;
        return $builder->where($column, $operator, $value, $this->boolean);
    }

}