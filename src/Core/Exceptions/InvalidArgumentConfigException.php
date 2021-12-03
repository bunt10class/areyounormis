<?php

declare(strict_types=1);

namespace Core\Exceptions;

class InvalidArgumentConfigException extends \InvalidArgumentException
{
    public function __construct()
    {
        parent::__construct('Invalid argument received in Config');
    }
}