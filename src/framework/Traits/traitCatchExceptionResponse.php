<?php

namespace Scriptpage\Traits;

use Exception;
use App\Traits\traitBaseResponse;

trait traitCatchExceptionResponse
{
    use traitBaseResponse;

    private $classException = [
        'Scriptpage\Exceptions\AuthorizationException' => 403,
        'Symfony\Component\HttpKernel\Exception\NotFoundHttpException' => 404,
        'Tymon\JWTAuth\Exceptions\TokenExpiredException' => 498,
        'Tymon\JWTAuth\Exceptions\TokenInvalidException' => 498,
        'Tymon\JWTAuth\Exceptions\UserNotDefinedException' => 498,
        // 'Illuminate\Validation\ValidationException'=> 400,
    ];

    private $messageCodeError = [
        400 => '400 Bad Request',
        403 => '403 Unauthorized',
        404 => '404 Not Found',
        498 => '498 Token is Invalid',
        500 => '500 Error Server'
    ];

    /**
     * Catch Exceptions
     * @param \Exception $e
     * @return array
     */
    protected function catchException(Exception $e)
    {
        $code = 500;
        $message = $e->getMessage();
        $errors = [
            'error_code' => $e->getCode(),
            'error_message' => $e->getMessage(),
            'exception_class' => get_class($e)
        ];
        
        if(isset($e->validator)) {
            $errors = array_merge($errors, $e->validator->errors()->toArray());
        }

        $class = get_class($e);
        if(isset($this->classException[$class])) {
            $code = $this->classException[$class];
            $message = $this->messageCodeError[$code];
        }

        $result = $this->baseResponse(
            $message,
            $errors,
            $result=null,
            $code
        );

        return $result;
    }
}