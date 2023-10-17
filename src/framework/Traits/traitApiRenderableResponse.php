<?php

namespace Scriptpage\Traits;

use Exception;
use Illuminate\Http\Request;

trait traitApiRenderableResponse
{

    use traitCatchExceptionResponse;
    
    /**
     * defining a global exception on your application's in App\Exceptions\Handler@register class.
     * 
     * add:
     * 
     *    $this->renderable(function (Exception $e, Request $request) {
     *       return $this->apiRenderableResponse($e, $request);
     *    });
     * 
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