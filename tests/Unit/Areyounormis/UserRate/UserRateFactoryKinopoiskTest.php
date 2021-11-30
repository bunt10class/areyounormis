<?php

declare(strict_types=1);

namespace Tests\Unit\Areyounormis\UserRate;

use Areyounormis\UserRate\Exceptions\UserRateVoteException;
use Areyounormis\UserRate\UserRateFactory;
use PHPUnit\Framework\TestCase;

class UserRateFactoryKinopoiskTest extends TestCase
{
    /**
     * @group unit
     * @group areyounormis
     * @group user_rate_factory
     */
    public function testMakeKinopoiskUserRate(): void
    {
        $result = UserRateFactory::makeKinopoiskUserRate($kpVote = 2, $userVote = 7);

        self::assertEquals(10, $result->getMaxVote());
        self::assertEquals(1, $result->getMinVote());
        self::assertEquals($kpVote, $result->getAvgVote());
        self::assertEquals($userVote, $result->getUserVote());
    }

    /**
     * @group unit
     * @group areyounormis
     * @group user_rate_factory
     */
    public function testMakeKinopoiskUserRateWithTooBigKpVote(): void
    {
        self::expectException(UserRateVoteException::class);

        UserRateFactory::makeKinopoiskUserRate(10.001, 7);
    }

    /**
     * @group unit
     * @group areyounormis
     * @group user_rate_factory
     */
    public function testMakeKinopoiskUserRateWithTooSmallKpVote(): void
    {
        self::expectException(UserRateVoteException::class);

        UserRateFactory::makeKinopoiskUserRate(0.999, 7);
    }

    /**
     * @group unit
     * @group areyounormis
     * @group user_rate_factory
     */
    public function testMakeKinopoiskUserRateWithTooBigUserVote(): void
    {
        self::expectException(UserRateVoteException::class);

        UserRateFactory::makeKinopoiskUserRate(2, 10.001);
    }

    /**
     * @group unit
     * @group areyounormis
     * @group user_rate_factory
     */
    public function testMakeKinopoiskUserRateWithTooSmallUserVote(): void
    {
        self::expectException(UserRateVoteException::class);

        UserRateFactory::makeKinopoiskUserRate(2, 0.999);
    }
}
