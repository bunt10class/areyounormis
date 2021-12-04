<?php

declare(strict_types=1);

namespace Areyounormis\Coefficient\Exceptions;

class InvalidCoefficientValueException extends CoefficientException
{
    public function __construct()
    {
        parent::__construct('Invalid coefficient value', 400);
    }
}