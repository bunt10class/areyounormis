<?php

declare(strict_types=1);

namespace Tests\Unit\Areyounormis\Service\Coefficient\CoefficientCalculator;

use Areyounormis\Service\Coefficient\CoefficientCalculator;
use PHPUnit\Framework\TestCase;

abstract class CoefficientCalculatorMain extends TestCase
{
    protected CoefficientCalculator $classUnderTest;

    public function setUp(): void
    {
        parent::setUp();

        $this->classUnderTest = new CoefficientCalculator();
    }
}
