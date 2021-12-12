<?php

declare(strict_types=1);

namespace Tests\Unit\Areyounormis\Mocks;

use Areyounormis\Service\Coefficient\CoefficientCalculator;
use Areyounormis\Domain\Vote\VoteList;

class CoefficientCalculatorMock extends CoefficientCalculator
{
    protected float $value;

    public function __construct(float $value = 0.5)
    {
        $this->value = $value;
    }

    public function calculateValue(string $type, VoteList $votes): float
    {
        return $this->value;
    }
}