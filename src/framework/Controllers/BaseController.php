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
use Scriptpage\Assets\traitResponse;
use Scriptpage\Framework;
use Scriptpage\Repository\BaseRepository;

class BaseController extends Controller
{
    use traitResponse;

    protected $cleanResponse = false;

    protected $responseError = [
        '403' => [
            'code' => 403,
            'message' => '403 Forbidden. allowFilters is False.'
        ]
    ];

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
     * Sorting of data presentation
     * @return array
     */
    private function startResponseWithPaginate()
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
            'errors' => null,
            'links' => null,
        ];
    }

    /**
     * Summary of response
     * @param Model|LengthAwarePaginator|Collection|array $result
     * @param string $message
     * @return JsonResponse
     */
    protected function response(BaseRepository|Model|LengthAwarePaginator|Collection|array $result, string $message = ''): JsonResponse
    {
        $total = $this->getTotalElements($result);

        if ($result instanceof LengthAwarePaginator) {
            $response = array_merge($this->startResponseWithPaginate(), $this->baseResponse(), $this->dataResult($result));
        } else {
            $response = array_merge($this->baseResponse(), $this->dataResult($result));
        }

        $response['message'] = (empty($message) and empty($response['message'])) ? 'Ok.' : $response['message'] . '.' . $message;
        $response['success'] = ($response['code'] == 200);
        $response['total'] = $response['total'] > 0
            ? $response['total']
            : $total;

        // Clean response by user definition in controller
        if ($this->cleanResponse == true) {
            $baseResponse = $this->baseResponse();
            foreach ($response as $key => $value) {
                if (!array_key_exists($key, $baseResponse))
                    unset($response[$key]);
            }
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
        if ($result instanceof LengthAwarePaginator)
            $total = $result->count();
        if (is_array($result))
            $total = 1; //count($result);
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
}