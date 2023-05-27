<?php

namespace Scriptpage\Controllers;

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
        return $this->sendResponse($this->repository->doQuery());
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

        return $this->sendResponse($result);
    }

    /**
     * Summary of toSql
     * @param \Illuminate\Http\Request $request
     * @return JsonResponse
     */
    public function toSql(Request $request)
    {
        $result = $this->urlQueryFilter
                    ? $this->repository->doQuery()
                    : $this->responseError['403'];

        return $this->sendResponse($result);
    }
}