<?php

namespace Scriptpage\Controllers;

use Exception;
use Scriptpage\Exceptions\AuthorizationException;
use Scriptpage\Exceptions\RepositoryException;
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

    function doQuery()
    {
        $result = null;
        $repository = $this->repository;
        try {
            $result = $this->response($repository->doQuery());
        } catch (Exception $e) {
            $code = 500;
            if ($e instanceof AuthorizationException) $code = 403;
            $result = $this->baseResponse(
                $e->getMessage(),
                $errors = [],
                $code
            );
        }
        return $result;
    }

    /**
     * Summary of index
     * @param Request $request
     * @return JsonResponse
     */
    public function index(Request $request)
    {
        return $this->response($this->doQuery());
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
            ? $this->doQuery()
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