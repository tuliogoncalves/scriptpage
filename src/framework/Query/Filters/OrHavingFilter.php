<?php

namespace Scriptpage\Query\Filters;

class OrHavingFilter extends HavingFilter
{
    protected $boolean = 'or';
}