<?php

declare(strict_types=1);

namespace Areyounormis\Domain\Report;

class ReportConfig
{
    private int $maxOverRateNumber;
    private int $maxUnderRateNumber;
    private float $maxEqualityDiff;
    private float $minInterestDiff;

    public function __construct(
        int $maxOverRateNumber,
        int $maxUnderRateNumber,
        float $maxEqualityRelativeDiff,
        float $minInterestModuleRelativeDiff,
    ) {
        $this->maxOverRateNumber = $maxOverRateNumber;
        $this->maxUnderRateNumber = $maxUnderRateNumber;
        $this->maxEqualityDiff = $maxEqualityRelativeDiff;
        $this->minInterestDiff = $minInterestModuleRelativeDiff;
    }

    public function getMaxOverRateNumber(): int
    {
        return $this->maxOverRateNumber;
    }

    public function getMaxUnderRateNumber(): int
    {
        return $this->maxUnderRateNumber;
    }

    public function getMaxEqualityDiff(): float
    {
        return $this->maxEqualityDiff;
    }

    public function getMinInterestDiff(): float
    {
        return $this->minInterestDiff;
    }
}