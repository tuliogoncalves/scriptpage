<?php

namespace Scriptpage\Controllers;

use App\Http\Controllers\Controller;
use Scriptpage\Contracts\IRepository;
use Scriptpage\Contracts\IService;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

class BaseController extends Controller
{
    protected IRepository $repository;

    protected IService $service;

    protected $repositoryClass;

    protected $serviceClass;

    protected $urlFilter = false;

    private $error404 = [
        'code' => 404,
        'message' => 'permission denied.'
    ];

    /**
     * Summary of getRepository
     * @return \Illuminate\Contracts\Foundation\Application |
     *          \Illuminate\Foundation\Application |
     *          mixed
     */
    public function getRepository()
    {
        return app($this->repositoryClass);
    }

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
        return $this->sendResponse($result ?? $this->error404);
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
        return $this->sendResponse($result ?? $this->error404);
    }

    /**
     * Summary of sendResponse
     * @param mixed $result
     * @param mixed $message
     * @param mixed $success
     * @param mixed $code
     * @return JsonResponse
     */
    public function sendResponse(array $result, $message = []): JsonResponse
    {
        $resp = [
            'data' => null,
            'success' => true,
            'code' => 200,
            'message' => $message,
        ];

        $response = array_merge($resp, $result);
        $response['success'] = ($response['code'] == 200);

        return response()->json(
            $response,
            $response['code'],
            ['Content-type' => 'application/json; charset=utf-8'],
            JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES
        );
    }
}