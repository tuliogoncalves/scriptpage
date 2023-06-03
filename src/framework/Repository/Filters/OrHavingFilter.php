<?php

namespace Scriptpage\Repository\Filters;

class OrHavingFilter extends HavingFilter
{
    protected $boolean = 'or';
}