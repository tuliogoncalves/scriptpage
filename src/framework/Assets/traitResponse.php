<?php

namespace Scriptpage\Assets;
use Exception;
use Illuminate\Http\Request;

trait traitResponse
{
    /**
     * Summary of response
     * @param string $message
     * @param int $code
     * @return array
     */
    public function baseResponse(string $message = null, array $errors = [], int $code = 200)
    {
        return [
            'code' => $code,
            'success' => ($code==200),
            'message' => $message,
            'total' => null,
            'current_page' => null,
            'errors' => $errors,
            'data' => []
        ];
    }

    /**
     * defining a register method on your application's App\Exceptions\Handler class.
     * add:
     *   $this->renderable(function (MethodNotAllowedHttpException $e, Request $request) {
     *        return $this->apiRenderableResponse($e, $request);
     *    });
     */
    public function apiRenderableResponse(Exception $e, Request $request) {
        // if ($request->is('api/*')) {
            return response()->json(
                $this->baseResponse(
                    $e->getMessage(),
                    [],
                    500
            ), 500);
        // }
    }
}
