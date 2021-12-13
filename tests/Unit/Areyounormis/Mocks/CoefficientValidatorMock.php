<?php

declare(strict_types=1);

namespace Tests\Unit\Areyounormis\Mocks;

use Areyounormis\Service\Coefficient\CoefficientValidator;
use Areyounormis\Service\Coefficient\Exceptions\InvalidCoefficientTypeException;
use Webmozart\Assert\InvalidArgumentException;

class CoefficientValidatorMock extends CoefficientValidator
{
    protected bool $isTypeException;
    protected bool $isArgumentException;

    public function __construct(
        bool $isTypeException = false,
        bool $isArgumentException = false,
    )
    {
        $this->isTypeException = $isTypeException;
        $this->isArgumentException = $isArgumentException;
    }

    public function validateType(string $type): void
    {
        if ($this->isTypeException) {
            throw new InvalidCoefficientTypeException($type);
        }
    }

    public function validateConfigData(mixed $coefficient): void
    {
        if ($this->isArgumentException) {
            throw new InvalidArgumentException();
        }
    }
}