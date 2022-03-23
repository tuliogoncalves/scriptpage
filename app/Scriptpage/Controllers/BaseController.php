<?php

namespace App\Scriptpage\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Inertia\Response;

class BaseController extends Controller
{

    use TraitController;


    /**
     * index
     *
     * @param  Request $request
     * @param  mixed $id
     * @param  mixed $id2
     * @return Response
     */
    public function index(Request $request, $id = null, $id2 = null)
    {
        $this->setBack($request);
        return $this->render(
            $this->template . '/index',
            $this->dataIndex($request, $id, $id2)
        );
    }


    /**
     * dataIndex
     *
     * @param  Request $request
     * @param  mixed $id
     * @param  mixed $id2
     * @return array
     */
    protected function dataIndex(Request $request, $id = null, $id2 = null): array
    {
        return [
            'paginator' => $this->repository->getData()
        ];
    }

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
