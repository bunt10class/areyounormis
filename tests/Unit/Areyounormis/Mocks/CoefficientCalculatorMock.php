<?php

declare(strict_types=1);

namespace Tests\Unit\Areyounormis\Mocks;

use Areyounormis\Coefficient\CoefficientCalculator;
use Areyounormis\Vote\Votes;

class CoefficientCalculatorMock extends CoefficientCalculator
{
    protected float $value;

    public function __construct(float $value = 0.5)
    {
        $this->value = $value;
    }

    public function calculateValue(string $type, Votes $votes): float
    {
        return $this->value;
    }
}