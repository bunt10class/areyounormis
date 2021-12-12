<?php

declare(strict_types=1);

namespace Areyounormis\Domain\Vote\Factories;

use Areyounormis\Domain\Vote\Vote;
use Areyounormis\Domain\Vote\VoteSystem;
use Areyounormis\Domain\Vote\Exceptions\VoteOutOfBoundariesException;

class VoteFactory
{
    /**
     * @throws VoteOutOfBoundariesException
     */
    public static function make(VoteSystem $voteSystem, float $userVote, float $siteVote): Vote
    {
        self::validateArguments($voteSystem, $userVote, $siteVote);

        $userVote = round($userVote, VoteSystem::PRECISION);
        $siteVote = round($siteVote, VoteSystem::PRECISION);
        $absoluteDiff = $userVote - $siteVote;
        $relativeDiff = round($absoluteDiff / $voteSystem->getDiff(), VoteSystem::PRECISION);
        $moduleRelativeDiff = abs($relativeDiff);

        return new Vote($userVote, $siteVote, $absoluteDiff, $relativeDiff, $moduleRelativeDiff);
    }

    /**
     * @throws VoteOutOfBoundariesException
     */
    protected static function validateArguments(VoteSystem $voteSystem, float $userVote, float $siteVote): void
    {
        if ($userVote < $voteSystem->getMin() || $userVote > $voteSystem->getMax()) {
            throw new VoteOutOfBoundariesException();
        }
        if ($siteVote < $voteSystem->getMin() || $siteVote > $voteSystem->getMax()) {
            throw new VoteOutOfBoundariesException();
        }
    }
}