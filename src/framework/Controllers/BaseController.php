<?php

namespace Scriptpage\Controllers;

use Illuminate\Foundation\Application;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use App\Http\Controllers\Controller;
use Scriptpage\Framework;
use Scriptpage\Repository\BaseRepository;

class BaseController extends Controller
{
    protected BaseRepository $repository;
    protected $repositoryClass;
    protected $urlQueryFilter = false;
    protected $responseError = [
        '403' => [
            'code' => 403,
            'message' => '403 Forbidden. urlFilter is False.'
        ]
    ];

    function __construct(Request $request)
    {
        $this->repository = 
            app($this->repositoryClass)
            ->setRequestData($request->all())
            ->setUrlQueryFilter($this->urlQueryFilter);
    }

    /**
     * Summary of sendResponse
     * @param mixed $result
     * @param mixed $message
     * @param mixed $success
     * @param mixed $code
     * @return JsonResponse
     */
    public function sendResponse(array $result, array $message = []): JsonResponse
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

    public function getVersion()
    {
        return $this->sendResponse([
            'data' => [
                'php' => PHP_VERSION,
                'laravel' => Application::VERSION,
                'scriptpage' => Framework::VERSION,
                config('app.project_name', 'app?') => config('app.version','?.0.0')
            ]
        ], ['Ok']);
    }
}