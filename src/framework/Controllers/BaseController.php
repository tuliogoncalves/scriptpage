<?php

namespace Scriptpage\Controllers;

use Exception;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Application;
use Illuminate\Http\JsonResponse;
use App\Http\Controllers\Controller;
use Illuminate\Support\Collection;
use Scriptpage\Framework;
use App\Traits\traitBaseResponse;

class BaseController extends Controller
{
    use traitBaseResponse;

    protected $cleanResponse = false;

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
     * @param mixed $result
     * @param string $message
     * @return \Illuminate\Http\JsonResponse
     */
    protected function response($result, string $message = '')
    {
        $total = $this->getTotalElements($result);

        if ($result instanceof LengthAwarePaginator) {
            $response = array_merge($this->baseResponseWithPaginate(), $this->baseResponse(), $this->dataResult($result));
        } else {
            $response = array_merge($this->baseResponse(), $this->dataResult($result));
        }

        $response['message'] = (empty($message) and empty($response['message'])) ? 'Ok.' : $response['message'] . '.' . $message;
        $response['success'] = ($response['code'] == 200);
        if (isset($response['total'])) {
            $response['total'] = $response['total'] > 0
                ? $response['total']
                : $total;
        }
        // Clean response by user definition in controller
        if ($this->cleanResponse) {
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
    private function getTotalElements(&$result): int
    {
        $total = 0;
        if ($result instanceof Model)
            $total = 1;
        if ($result instanceof Collection)
            $total = $result->count();
        if ($result instanceof LengthAwarePaginator)
            $total = $result->count();
        if (is_array($result) or is_object($result))
            $total = 1;
        return $total;
    }

    /**
     * When none data key, add one
     * @param mixed $result
     * @return array
     */
    private function dataResult(&$result): array
    {
        if (is_object($result)) {
            $result = $result->toArray();
        }

        if (!is_array($result)) {
            $result = (array)strval($result);
        }

        return array_key_exists('data', $result)
            ? $result
            : $result[] = [
                'data' => $result
            ];
    }
}
