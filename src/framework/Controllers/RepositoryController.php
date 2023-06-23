<?php

namespace Scriptpage\Controllers;

use Exception;
use Scriptpage\Exceptions\AuthorizationException;
use Scriptpage\Exceptions\ValidationException;
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
            ->setInputs($request->all())
            ->setFilters($request->query())
            ->setAllowFilters($this->allowFilters);
    }

    function doQuery()
    {
        $result = null;
        $repository = $this->repository;
        try {
            $result = $repository->doQuery();
        } catch (Exception $e) {
            $result = $this->catchException($e);
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

    function store(Request $request)
    {
        $result = null;

        $repository = $this->repository;
        try {
            $result = $repository->store();
        } catch (Exception $e) {
            $result = $this->catchException($e);
        }
        return $this->response($result);
    }

    function update(Request $request, $id)
    {
        $result = null;
        $repository = $this->repository;
        try {
            $result = $repository->update($id);
        } catch (Exception $e) {
            $result = $this->catchException($e);
        }
        return $this->response($result);
    }

    protected function catchException(Exception $e)
    {
        $code = 500;
        $errors = [];
        if ($e instanceof AuthorizationException)
            $code = 403;
        if ($e instanceof ValidationException) {
            $errors = $e->getErrors();
            $code = 400;
        }
        $result = $this->baseResponse(
            $e->getMessage(),
            $errors,
            $code
        );
        return $result;
    }
}