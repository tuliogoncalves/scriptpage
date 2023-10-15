<?php

namespace App\Traits;

use Exception;
use Scriptpage\Exceptions\AuthorizationException;
use Scriptpage\Exceptions\RepositoryException;
use Scriptpage\Exceptions\ValidationException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Tymon\JWTAuth\Exceptions\TokenExpiredException;
use Tymon\JWTAuth\Exceptions\TokenInvalidException;
use Tymon\JWTAuth\Exceptions\UserNotDefinedException;

trait traitCatchExceptionResponse
{
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

        if ($e instanceof TokenInvalidException) {
            $code = 498;
            $message = '498 Token is Invalid';
        }

        if ($e instanceof TokenExpiredException) {
            $code = 498;
            $message = '498 Token is Expired';
        }

        if ($e instanceof UserNotDefinedException) {
            $code = 498;
            $message = '498 Token is invalid';
        }

        if ($e instanceof AuthorizationException) {
            $code = 403;
            $message = '403 Unauthorized';
            $errors = array_merge(
                $e->getErrors(),
                $errors
            );
        }
        if ($e instanceof NotFoundHttpException) {
            $code = 404;
            $message = '404 Not Found';
        }

        if ($e instanceof ValidationException) {
            $code = 400;
            $message = 'the server cannot or will not process the request due to something that is perceived to be a client error';
            $errors = array_merge(
                $e->getErrors(),
                $errors
            );
        }

        if ($e instanceof RepositoryException) {
            $errors = array_merge(
                $e->getErrors(),
                $errors
            );
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