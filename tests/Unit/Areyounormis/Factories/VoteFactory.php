<?php

declare(strict_types=1);

namespace Tests\Unit\Areyounormis\Factories;

use Areyounormis\Domain\Vote\Vote;
use Areyounormis\Domain\Vote\VoteList;
use Areyounormis\Domain\Vote\VoteSystem;

class VoteFactory
{
    public static function getDefaultItem(float $userVote, float $siteVote): Vote
    {
        $voteSystem = VoteSystemFactory::getDefault();
        $absoluteDiff = $userVote - $siteVote;
        $relativeDiff = round($absoluteDiff / $voteSystem->getDiff(), VoteSystem::PRECISION);
        $moduleRelativeDiff = abs($relativeDiff);

        return new Vote($userVote, $siteVote, $absoluteDiff, $relativeDiff, $moduleRelativeDiff);
    }

    public static function getEmptyList(): VoteList
    {
        return new VoteList();
    }

    public static function getListWithOneDefaultItem(float $userVote, float $siteVote): VoteList
    {
        $votes = self::getEmptyList();
        $votes->addItem(self::getDefaultItem($userVote, $siteVote));

        return $votes;
    }
}