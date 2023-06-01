<?php

namespace Scriptpage\Controllers;

use Exception;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Foundation\Application;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use App\Http\Controllers\Controller;
use Illuminate\Support\Collection;
use Scriptpage\Framework;
use Scriptpage\Repository\BaseRepository;

class BaseController extends Controller
{
    protected BaseRepository $repository;
    protected $repositoryClass;
    protected $urlQueryFilter = false;
    protected $cleanResponse = false;
    protected $responseError = [
        '403' => [
            'code' => 403,
            'message' => '403 Forbidden. urlQueryFilter is False.'
        ]
    ];

    function __construct(Request $request)
    {
        $this->repository =
            app($this->repositoryClass)
                ->setUrlQuery($request->all())
                ->setUrlQueryFilter($this->urlQueryFilter);
    }

    protected function doQuery(LengthAwarePaginator|Collection $result, array $filters = []): array
    {
        if ($result instanceof Collection) {
            $result = $result->flatten(1);
        }
        $result = $result->toArray();

        return $result;

        // try {
        //     if ($result instanceof Collection) {
        //         $result = $result->flatten(1);
        //         $result = [
        //             'data' => $result->toArray()
        //         ];
        //     } else {
        //         $result = $result->toArray();
        //     }
        //     $result['message'] = 'Success query.';
        // } catch (Exception $e) {
        //     $result = [
        //         'code' => 500,
        //         'message' => $e->getMessage()
        //     ];
        // }

        // return $result;
    }

    public function formatResult(array $result)
    {
        return isset($result['data'])
            ? $result
            : $result[] = [
                'data' => $result
            ];
    }

    /**
     * Summary of response
     * @param mixed $result
     * @param mixed $message
     * @param mixed $success
     * @param mixed $code
     * @return JsonResponse
     */
    protected function response(array $result, string $message = ''): JsonResponse
    {
        $resp = [
            'success' => true,
            'code' => 200,
            'message' => empty($message) ? 'Ok.' : $message,
            'total' => null,
            'per_page' => null,
            'current_page' => null,
            'last_page' => null,
            'first_page_url' => null,
            'last_page_url' => null,
            'next_page_url' => null,
            'prev_page_url' => null,
            'path' => null,
            'from' => null,
            'to' => null,
            'data' => null,
            'links' => null,
        ];

        $response = array_merge($resp, $this->formatResult($result));
        $response['success'] = ($response['code'] == 200);

        if (is_null($response['per_page'])) {
            unset($response['per_page']);
            unset($response['current_page']);
            unset($response['last_page']);
            unset($response['from']);
            unset($response['to']);
            unset($response['first_page_url']);
            unset($response['last_page_url']);
            unset($response['next_page_url']);
            unset($response['prev_page_url']);
            unset($response['path']);
            unset($response['links']);

            if (is_array($response['data'])) {
                $response['total'] = count($response['data']);
            } else {
                unset($response['total']);
            }
        }

        if ($this->cleanResponse == true) {
            unset($response['first_page_url']);
            unset($response['last_page_url']);
            unset($response['next_page_url']);
            unset($response['prev_page_url']);
            unset($response['path']);
            unset($response['links']);
        }

        return response()->json(
            $response,
            $response['code'],
            ['Content-type' => 'application/json; charset=utf-8'],
            JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES
        );
    }

    protected function getVersion()
    {
        return $this->response([
            'data' => [
                'php' => PHP_VERSION,
                'laravel' => Application::VERSION,
                'scriptpage' => Framework::VERSION,
                config('app.project_name', 'app?') => config('app.version', '?.0.0')
            ]
        ], 'Ok');
    }
}