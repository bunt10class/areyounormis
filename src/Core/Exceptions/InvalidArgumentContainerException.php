<?php

declare(strict_types=1);

namespace Core\Exceptions;

class InvalidArgumentContainerException extends \InvalidArgumentException
{
    public function __construct()
    {
        parent::__construct('Invalid argument received in Container');
    }
}