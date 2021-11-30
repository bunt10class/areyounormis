<?php

declare(strict_types=1);

namespace Tests\Unit\Areyounormis\Report\CoefficientCalculator;

use Areyounormis\Report\CoefficientCalculator;
use PHPUnit\Framework\TestCase;
use Tests\Unit\Areyounormis\Factories\UserRateFactory;

abstract class CoefficientCalculatorMain extends TestCase
{
    protected CoefficientCalculator $classUnderTest;
    protected UserRateFactory $factory;

    public function setUp(): void
    {
        parent::setUp();

        $this->classUnderTest = new CoefficientCalculator();
        $this->factory = new UserRateFactory();
    }
}