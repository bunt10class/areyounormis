<?php

declare(strict_types=1);

namespace Areyounormis\Domain\Report;

use Areyounormis\Domain\Vote\VoteSystem;

class ReportConfigFactory
{
    private const DEFAULT_MAX_TOP_NUMBER = 10;
    private const DEFAULT_MIN_INTEREST_DIFF = 0.3;

    public static function makeDefault(VoteSystem $voteSystem): ReportConfig
    {
        return new ReportConfig(
            self::DEFAULT_MAX_TOP_NUMBER,
            self::DEFAULT_MAX_TOP_NUMBER,
            $voteSystem->getRelativeStep() / 2,
            self::DEFAULT_MIN_INTEREST_DIFF,
        );
    }
}