<?php

namespace Scriptpage\Middleware;

use Closure;
use Exception;
use Illuminate\Http\Request;
use Tymon\JWTAuth\Exceptions\TokenInvalidException;
use Tymon\JWTAuth\Exceptions\TokenExpiredException;

class EnsureUserHasRole
{
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
                return response()->json(['status' => '498 Token is Invalid'], 498);
            } elseif ($e instanceof TokenExpiredException) {
                return response()->json(['status' => '401 Token is Expired'], 401);
            }
        }

        if (!$hasRole)
           return response()->json(['status' => '403 Unauthorized'], 403);

        return $next($request);
    }
}