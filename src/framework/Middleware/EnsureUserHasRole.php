<?php

namespace Scriptpage\Middleware;

use Closure;
use Exception;
use Illuminate\Http\Request;
use Scriptpage\Assets\traitResponse;
use Tymon\JWTAuth\Exceptions\TokenInvalidException;
use Tymon\JWTAuth\Exceptions\TokenExpiredException;

class EnsureUserHasRole
{
    use traitResponse;

    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next, $role = null)
    {
        $hasRole = false;

        try {
            $user = auth('api')->userOrFail();
            $hasRole = is_null($role)
                ? true
                : $user->hasRole($role);
        } catch (Exception $e) {
            if ($e instanceof TokenInvalidException) {
                return $this->response('498 Token is Invalid', 498);
            }

            if ($e instanceof TokenExpiredException) {
                return $this->response('401 Token is Expired', 401);
            }

            return $this->response(
                '500 Unexpected Exception',
                500,
                [$e->getMessage() . '.Error code:' . $e->getCode()],
            );

        }

        if (!$hasRole)
            return $this->response('403 Unauthorized', 403);

        return $next($request);
    }

    function response($message, $code, $errors = null)
    {
        return response()->json(
            $this->baseResponse(
                $message,
                $errors,
                $code
            ),
            $code
        );
    }
}