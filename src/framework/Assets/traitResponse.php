<?php

namespace Scriptpage\Assets;

trait traitResponse
{
    /**
     * Summary of response
     * @param string $message
     * @param int $code
     * @return array
     */
    final public function baseResponse(string $message = null, array $errors = [], int $code = 200)
    {
        return [
            'code' => $code,
            'success' => null,
            'message' => $message,
            'total' => null,
            'current_page' => null,
            'data' => [],
            'errors' => $errors
        ];
    }
}
