<?php

declare(strict_types=1);

namespace Areyounormis\UserMovie\Models\ClientRequest\Parser;

use Exception;

class InvalidRequestInString extends Exception
{
    public function __construct()
    {
        parent::__construct('Invalid request in string ', 422);
    }
}