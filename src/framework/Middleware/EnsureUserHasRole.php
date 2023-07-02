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

        $user = auth('api')->userOrFail();
        $hasRole = is_null($role)
            ? true
            : $user->hasRole($role);

        if (!$hasRole)
            return $this->response('403 Unauthorized Roles (Middleware)', 403, $errors);

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