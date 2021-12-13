<?php

declare(strict_types=1);

namespace Tests\Unit\Areyounormis\Service\Coefficient\CoefficientValidator;

use Areyounormis\Service\Coefficient\CoefficientValidator;
use PHPUnit\Framework\TestCase;

abstract class CoefficientValidatorMain extends TestCase
{
    protected CoefficientValidator $classUnderTest;

    protected function setUp(): void
    {
        parent::setUp();

        $this->classUnderTest = new CoefficientValidator();
    }
}
