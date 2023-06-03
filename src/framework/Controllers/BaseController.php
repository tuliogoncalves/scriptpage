<?php

namespace Scriptpage\Controllers;

use Exception;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Model;
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

    /**
     * Summary of response
     * @param LengthAwarePaginator|Collection|array $result
     * @param string $message
     * @return JsonResponse
     */
    protected function response(BaseRepository|Model|LengthAwarePaginator|Collection|array $result, string $message = ''): JsonResponse
    {
        $total = $this->getTotalElements($result);
        $response = array_merge($this->baseResponse(), $this->dataResult($result));

        if (is_null($response['total']))
            $response['total'] = $total;
        $response['message'] = (empty($message) and empty($response['message'])) ? 'Ok.' : $response['message'].'.'.$message;
        $response['success'] = ($response['code'] == 200);

        // Clean Paginate Response
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
        }

        // Clean response by user definition
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

    /**
     * Summary of getTotalElements
     * @param mixed $result
     * @return int
     */
    private function getTotalElements(mixed &$result): int
    {
        $total = 0;
        if ($result instanceof Model)
            $total = 1;
        if ($result instanceof Collection)
            $total = $result->count();
        if (is_array($result))
            $total = count($result);
        return $total;
    }

    /**
     * When none data key, add one
     * @param mixed $result
     * @return array
     */
    private function dataResult(mixed &$result): array
    {
        if (!is_array($result)) {
            $result = $result->toArray();
        }

        return isset($result['data'])
            ? $result
            : $result[] = [
                'data' => $result
            ];
    }

    private function baseResponse()
    {
        return [
            'success' => true,
            'code' => 200,
            'message' => '',
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
    }

}