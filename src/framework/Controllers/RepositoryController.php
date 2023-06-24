<?php

namespace Scriptpage\Controllers;

use Exception;
use Scriptpage\Exceptions\AuthorizationException;
use Scriptpage\Exceptions\ValidationException;
use Scriptpage\Repository\BaseRepository;
use Illuminate\Http\Request;

class RepositoryController extends BaseController
{
    protected $allowFilters = false;

    function startRepository(BaseRepository $repository = null)
    {
        $request = request();
        $repository
            ->setInputs($request->all())
            ->setFilters($request->query())
            ->setAllowFilters($this->allowFilters);
        return $repository;
    }
}