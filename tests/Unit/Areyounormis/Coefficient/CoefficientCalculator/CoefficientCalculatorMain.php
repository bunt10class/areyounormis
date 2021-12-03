<?php

declare(strict_types=1);

namespace Tests\Unit\Areyounormis\Coefficient\CoefficientCalculator;

use Areyounormis\Coefficient\CoefficientCalculator;
use Areyounormis\Vote\VoteSystem;
use Areyounormis\Vote\VoteSystemFactory;
use PHPUnit\Framework\TestCase;

abstract class CoefficientCalculatorMain extends TestCase
{
    protected CoefficientCalculator $classUnderTest;

    public function setUp(): void
    {
        parent::setUp();

        $this->classUnderTest = new CoefficientCalculator();
    }

    protected function makeTenZeroOneVoteSystem(): VoteSystem
    {
        return VoteSystemFactory::make(10, 0 , 1);
    }
}
