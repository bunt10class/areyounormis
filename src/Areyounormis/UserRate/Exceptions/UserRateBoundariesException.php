<?php

declare(strict_types=1);

namespace Areyounormis\UserRate\Exceptions;

class UserRateBoundariesException extends UserRateException
{
    public function __construct()
    {
        parent::__construct('Invalid boundaries', 400);
    }
}