<?php

declare(strict_types=1);

namespace Areyounormis\Service\Coefficient;

use Areyounormis\Infrastructure\Coefficient\Exceptions\InvalidCoefficientTypeException;
use Areyounormis\Domain\Coefficient\CoefficientHelper;
use Areyounormis\Domain\Vote\VoteList;

class CoefficientCalculator
{
    /**
     * @throws InvalidCoefficientTypeException
     */
    public function calculateValue(string $type, VoteList $votes): float
    {
        switch ($type) {
            case CoefficientHelper::NORM_TYPE:
                return $this->calculateNormCoefficient($votes);
            case CoefficientHelper::OVER_UNDER_RATE_TYPE:
                return $this->calculateOverUnderRateCoefficient($votes);
        }
        throw new InvalidCoefficientTypeException($type);
    }

    public function calculateNormCoefficient(VoteList $votes): float
    {
        $count = $votes->getCount();
        if (!$count) {
            return 1;
        }

        $moduleRelativeDiffSum = 0;
        foreach ($votes->getItems() as $vote) {
            $moduleRelativeDiffSum += $vote->getModuleRelativeDiff();
        }

        return 1 - round($moduleRelativeDiffSum / $count, CoefficientHelper::PRECISION);
    }

    public function calculateOverUnderRateCoefficient(VoteList $votes): float
    {
        $count = $votes->getCount();
        if (!$count) {
            return 0;
        }

        $relativeDiffSum = 0;
        foreach ($votes->getItems() as $vote) {
            $relativeDiffSum += $vote->getRelativeDiff();
        }

        return round($relativeDiffSum / $count, CoefficientHelper::PRECISION);
    }
}