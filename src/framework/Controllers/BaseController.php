<?php

namespace Scriptpage\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use App\Http\Controllers\Controller;
use Scriptpage\Contracts\IRepository;

class BaseController extends Controller
{
    protected IRepository $repository;
    protected $repositoryClass;
    protected $urlFilter = false;
    protected $responseError = [
        '403' => [
            'code' => 403,
            'message' => '403 Forbidden. urlFilter is False.'
        ]
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