<?php

namespace Scriptpage\Controllers;

use Exception;
use Illuminate\Http\Request;

class AuthController extends BaseController
{
    /**
     * Get a JWT via given credentials.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function login(Request $request)
    {
        $result = [];
        $message = '';
        $credentials = $request->only(['email', 'password']);

        try {
            $result = [
                // 'code' => 200,
                // 'data' => [],
                'access_token' => auth('api')->attempt($credentials),
                'token_type' => 'bearer',
                'expires_in' => auth('api')->factory()->getTTL() * 60
            ];
        } catch (Exception $e) {
            $message = 'Unauthorized';
            $result = [
                'code' => 403,
                'data' => [],
                'errors' => [$e->getMessage() . '.Error code:' . $e->getCode()]
            ];
        }

        return $this->response($result, $message);
    }

    /**
     * Get the authenticated User.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function me(Request $request)
    {
        $user = auth('api')->user();
        $user->roles;
        return $this->response($user);
    }

    /**
     * Log the user out (Invalidate the token).
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function logout(Request $request)
    {
        auth('api')->logout();

        return $this->response([
            'data' => [],
            'message' => 'Successfully logged out'
        ]);
    }

    /**
     * Refresh a token.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function refresh(Request $request)
    {
        return $this->responseWithToken(auth('api')->refresh());
    }
}