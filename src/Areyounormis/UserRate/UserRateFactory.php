<?php

declare(strict_types=1);

namespace Areyounormis\UserRate;

use Areyounormis\UserRate\Exceptions\UserRateBoundariesException;
use Areyounormis\UserRate\Exceptions\UserRateVoteException;
use Kinopoisk\VoteHelper;

class UserRateFactory
{
    /**
     * @throws UserRateBoundariesException
     * @throws UserRateVoteException
     */
    public static function makeKinopoiskUserRate(float $kpVote, float $userVote): UserRate
    {
        return new UserRate(VoteHelper::MAX_VOTE, VoteHelper::MIN_VOTE, $kpVote, $userVote);
    }

    public static function makeUserRates(): UserRates
    {
        return new UserRates();
    }
}