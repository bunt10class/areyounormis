<?php

declare(strict_types=1);

namespace Areyounormis\Domain\Vote\Factories;

use Areyounormis\Domain\Vote\VoteSystem;
use Areyounormis\Domain\Vote\Exceptions\VoteSystemException;
use Kinopoisk\VoteHelper;

class VoteSystemFactory
{
    /**
     * @throws VoteSystemException
     */
    public static function make(float $max, float $min, float $step): VoteSystem
    {
        self::validateParams($max, $min, $step);

        $max = round($max, VoteSystem::PRECISION);
        $min = round($min, VoteSystem::PRECISION);
        $maxDiff = $max - $min;
        $step = round($step, VoteSystem::PRECISION);
        $relativeStep = round($step / $maxDiff, VoteSystem::PRECISION);

        return new VoteSystem($max, $min, $maxDiff, $step, $relativeStep);
    }

    /**
     * @throws VoteSystemException
     */
    protected static function validateParams(float $max, float $min, float $step): void
    {
        if ($min < 0 || $min >= $max || $step <= 0 || $step > $max) {
            throw new VoteSystemException();
        }

        $multiplicity = round(($max - $min) / $step, VoteSystem::PRECISION);
        if ($multiplicity !== round($multiplicity)) {
            throw new VoteSystemException();
        }
    }

    /**
     * @throws VoteSystemException
     */
    public static function makeForKinopoisk(): VoteSystem
    {
        return self::make(VoteHelper::MAX_VOTE, VoteHelper::MIN_VOTE, VoteHelper::VOTE_STEP);
    }
}