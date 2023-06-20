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

class RepositoryException extends BaseException
{
    /**
     * {@inheritdoc}
     */
    protected $message = 'An error occurred in repository';
    
}
