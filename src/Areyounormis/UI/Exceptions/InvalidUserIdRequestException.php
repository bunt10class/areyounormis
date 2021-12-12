<?php

declare(strict_types=1);

namespace Areyounormis\UI\Exceptions;

use Core\Exceptions\RequestException;

class InvalidUserIdRequestException extends RequestException
{
    public function __construct(string $explanation)
    {
        parent::__construct('Идентификатор пользователя ' . $explanation);
    }
}