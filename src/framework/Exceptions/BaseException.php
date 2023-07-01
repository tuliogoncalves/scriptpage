<?php

/*
 * This file is part of scriptpage framework.
 *
 * (c) Túlio Gonçalves <tuliogoncalves@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Scriptpage\Exceptions;

use Exception;
use Throwable;

class BaseException extends Exception
{
    /**
     * {@inheritdoc}
     */
    protected $message = 'An error occurred';
    
    protected $errors = [];
    
    /**
     * Create a new exception instance.
     *
     * @param  string|null  $message
     * @param  mixed  $code
     * @param  array $errors
     * @param  \Throwable|null  $previous
     * @return void
     */
    public function __construct($message = null, $code = null, array $errors=[], Throwable $previous = null)
    {
        parent::__construct($message ?? $this->message, 0, $previous);

        $this->code = $code ?: 0;
        $this->errors = $errors;
    }

    public function getErrors() {
        return $this->errors;
    }
}
