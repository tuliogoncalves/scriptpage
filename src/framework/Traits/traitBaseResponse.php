<?php

namespace App\Traits;

trait traitBaseResponse
{
    /**
     * Summary of response
     * @param string $message
     * @param int $code
     * @return array
     */
    public function baseResponse(string $message = null, array $errors = null, string $result = null, int $code = 200)
    {
        return [
            'code' => $code,
            'success' => ($code == 200),
            'message' => $message,
            'total' => null,
            'current_page' => null,
            'errors' => $errors,
            'data' => isset($result) ? [$result] : []
        ];
    }


    /**
     * Sorting of data presentation
     * @return array
     */
    private function baseResponseWithPaginate()
    {
        return [
            'success' => true,
            'code' => 200,
            'message' => '',
            'total' => null,
            'per_page' => null,
            'current_page' => null,
            'last_page' => null,
            'first_page_url' => null,
            'last_page_url' => null,
            'next_page_url' => null,
            'prev_page_url' => null,
            'path' => null,
            'from' => null,
            'to' => null,
            'errors' => [],
            'data' => null,
            'links' => null,
        ];
    }

}