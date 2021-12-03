<?php

declare(strict_types=1);

namespace Areyounormis\Coefficient\Exceptions;

class InvalidCoefficientTypeException extends CoefficientException
{
    public function __construct(string $type)
    {
        parent::__construct('Invalid coefficient type: ' . $type, 400);
    }
}