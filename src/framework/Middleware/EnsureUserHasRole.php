<?php

namespace Scriptpage\Middleware;

use Closure;
use Exception;
use Illuminate\Http\Request;
use Scriptpage\Assets\traitResponse;
use Tymon\JWTAuth\Exceptions\TokenInvalidException;
use Tymon\JWTAuth\Exceptions\TokenExpiredException;
use Tymon\JWTAuth\Exceptions\UserNotDefinedException;

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
        $errors = [];

        try {
            $user = auth('api')->userOrFail();
            $hasRole = is_null($role)
                ? true
                : $user->hasRole($role);
        } catch (Exception $e) {
            $errors = [
                $e->getMessage() . '.Error code:' . $e->getCode(),
                // 'error_class: ' . get_class($e)
            ];

            if ($e instanceof TokenInvalidException) {
                return $this->response('498 Token is Invalid', 498, $errors);
            }

            if ($e instanceof TokenExpiredException) {
                return $this->response('401 Token is Expired', 401, $errors);
            }
        }

        if (!$hasRole)
            return $this->response('403 Unauthorized', 403, $errors);

        return $next($request);
    }

    function response($message, $code, $errors = [])
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