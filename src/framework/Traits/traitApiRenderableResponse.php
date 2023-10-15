<?php

namespace App\Traits;

use Exception;
use Illuminate\Http\Request;

trait traitApiRenderableResponse
{

    /**
     * defining a register method on your application's App\Exceptions\Handler class.
     * add:
     *    $this->renderable(function (Exception $e, Request $request) {
     *       return $this->apiRenderableResponse($e, $request);
     *    });
     */
    public function apiRenderableResponse(Exception $e, Request $request)
    {
        if ($request->is('api/*')) {
            $response = $this->catchException($e);
            return response()->json(
                $response,
                $response['code']
            );
        }
    }

}