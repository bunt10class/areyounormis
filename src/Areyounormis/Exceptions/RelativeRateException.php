<?php

declare(strict_types=1);

namespace Areyounormis\Exceptions;

use Exception;

class RelativeRateException extends Exception
{
    public function __construct()
    {
        parent::__construct('Invalid value for relative rate', 400);
    }
}