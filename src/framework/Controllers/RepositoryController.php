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
        $repository = $this->getRepository();
        $repository->newQuery();
        if ($this->urlFilter)
            $repository->urlFilter($request->all());
        $result = $repository->doQuery();
        return $this->sendResponse($result);
    }

    /**
     * Summary of queryDb
     * @param \Illuminate\Http\Request $request
     * @return JsonResponse
     */
    public function queryDb(Request $request)
    {
        $repository = $this->getRepository();
        $repository->newQueryDB();
        if ($this->urlFilter) {
            $repository->urlFilter($request->all());
            $result = $repository->doQuery();
        }
        return $this->sendResponse($result ?? $this->responseError['403']);
    }

    /**
     * Summary of toSql
     * @param \Illuminate\Http\Request $request
     * @return JsonResponse
     */
    public function toSql(Request $request)
    {
        $repository = $this->getRepository();
        $repository->newQuery();
        if ($this->urlFilter) {
            $repository->urlFilter($request->all());
            $result = $repository->toSql();
        }
        return $this->sendResponse($result ?? $this->responseError['403']);
    }
}