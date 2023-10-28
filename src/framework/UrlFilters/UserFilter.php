<?php

namespace App\UrlFilters;

use Scriptpage\Query\UrlFilter;

class UserFilter extends UrlFilter
{
    protected $customFilters = [
        'search'
    ];

    function search(string $search="")
    {
        $query = $this->getBuilder();

        $query->Where('name', 'like', '%' . $search . '%')
            ->orWhere('email', 'like', '%' . $search . '%');

        return $query;
    }
}