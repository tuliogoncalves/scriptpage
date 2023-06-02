<?php

namespace Scriptpage\Controllers;

use Exception;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;


class RepositoryController extends BaseController
{
    /**
     * Summary of index
     * @param \Illuminate\Http\Request $request
     * @return JsonResponse
     */
    public function index(Request $request)
    {
        $repository = $this->repository;
        return $this->response($repository->doQuery());
    }

    /**
     * Summary of queryDb
     * @param \Illuminate\Http\Request $request
     * @return JsonResponse
     */
    public function queryDb(Request $request)
    {
        $repository = $this->repository;
        $repository->newDB();

        $result = $this->urlQueryFilter
            ? $repository->doQuery()
            : $this->responseError['403'];

        return $this->response($result);
    }

    /**
     * Summary of toSql
     * @param \Illuminate\Http\Request $request
     * @return JsonResponse
     */
    public function toSql(Request $request)
    {
        $result = $this->urlQueryFilter
            ? $this->repository->toSql()
            : $this->responseError['403'];

        return $this->response($result);
    }
}