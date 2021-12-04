<?php

declare(strict_types=1);

namespace Tests\Unit\Areyounormis\Factories;

use Areyounormis\Vote\Vote;
use Areyounormis\Vote\VoteFactory as AreyounormisVoteFactory;
use Areyounormis\Vote\VoteSystem;
use Areyounormis\Vote\VoteSystemFactory;

class VoteFactory
{
    public static function getTenZeroOneVoteSystem(): VoteSystem
    {
        return VoteSystemFactory::make(10, 0, 1);
    }

    public static function getTenZeroOneVote(float $userVote, float $siteVote): Vote
    {
        return AreyounormisVoteFactory::make(self::getTenZeroOneVoteSystem(), $userVote, $siteVote);
    }
}