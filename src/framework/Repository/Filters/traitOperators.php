<?php

namespace Scriptpage\Repository\Filters;

use Scriptpage\Contracts\IRepository;

trait traitOperators
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
   
    protected $builder;

    function apply(IRepository $repository, string $expressions)
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
}