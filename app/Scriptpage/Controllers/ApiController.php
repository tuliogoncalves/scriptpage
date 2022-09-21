<?php

namespace App\Scriptpage\Controllers;

use Illuminate\Http\JsonResponse;
use App\Scriptpage\Contracts\IRepository;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;

class ApiController extends BaseController
{

    /**
     * success response method.
     *
     * @param $result
     * @param $message
     * @param bool $valida
     * @return JsonResponse
     */
    public function sendResponse($result, $message, bool $valida = true): JsonResponse
    {
        $response = [
            'success' => $valida,
            'data'    => $result,
            'message' => $message,
        ];
        return response()->json($response, 200);
    }

    /**
     * return error response.
     *
     * @param $error
     * @param array $errorMessages
     * @param int $code
     *
     * @return JsonResponse
     */
    public function sendError($error, array $errorMessages = [], int $code = 404): JsonResponse
    {
        $response = [
            'success' => false,
            'message' => $error,
        ];


        if (!empty($errorMessages)) {
            $response['data'] = $errorMessages;
        }


        return response()->json($response, $code);
    }
}
