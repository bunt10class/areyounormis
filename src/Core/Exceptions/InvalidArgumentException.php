<?php

declare(strict_types=1);

namespace Core\Exceptions;

use Exception;

class InvalidArgumentException extends Exception
{
    public function __construct(string $message = '')
    {
        if (!$message) {
            $message = 'Invalid argument';
        }
        parent::__construct($message, 400);
    }
}