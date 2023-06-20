<?php

namespace Scriptpage\Controllers;

use Exception;
use Scriptpage\Repository\BaseRepository;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;


class RepositoryController extends BaseController
{
    protected $repositoryClass;
    protected BaseRepository $repository;
    protected $allowFilters = false;

    function __construct(Request $request)
    {
        $this->repository = new $this->repositoryClass;
        $this->repository
                ->setFilters($request->query())
                ->setAllowFilters($this->allowFilters);
    }

    /**
     * Summary of index
     * @param Request $request
     * @return JsonResponse
     */
    public function index(Request $request)
    {
        $repository = $this->repository;
        return $this->response($repository->doQuery());
    }

    /**
     * Summary of queryDb
     * @param Request $request
     * @return JsonResponse
     */
    public function queryDb(Request $request)
    {
        $repository = $this->repository;
        $repository->newDB();

        $result = $this->allowFilters
            ? $repository->doQuery()
            : $this->responseError['403'];

        return $this->response($result);
    }

    /**
     * Summary of toSql
     * @param Request $request
     * @return JsonResponse
     */
    public function toSql(Request $request)
    {
        $result = $this->repository->toSql();

        return $this->response($result);
    }
}