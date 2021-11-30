<?php

declare(strict_types=1);

namespace Tests\Unit\Areyounormis\UserRate;

use Areyounormis\UserRate\Exceptions\UserRateBoundariesException;
use Areyounormis\UserRate\Exceptions\UserRateVoteException;
use Areyounormis\UserRate\UserRate;
use PHPUnit\Framework\TestCase;

class UserRateTest extends TestCase
{
    /**
     * @group unit
     * @group areyounormis
     * @group user_rate
     */
    public function testConstructWithValidArguments(): void
    {
        new UserRate(10, 0, 2, 7);

        self::assertTrue(true);
    }

    /**
     * @group unit
     * @group areyounormis
     * @group user_rate
     */
    public function testConstructWithMaxVoteLessThanZero(): void
    {
        self::expectException(UserRateBoundariesException::class);

        $maxVote = -0.001;
        new UserRate($maxVote, 0, 2, 7);
    }

    /**
     * @group unit
     * @group areyounormis
     * @group user_rate
     */
    public function testConstructWithMinVoteLessThanZero(): void
    {
        self::expectException(UserRateBoundariesException::class);

        $minVote = -0.001;
        new UserRate(10, $minVote, 2, 7);
    }

    /**
     * @group unit
     * @group areyounormis
     * @group user_rate
     */
    public function testConstructWithMaxVoteEqualMinVote(): void
    {
        self::expectException(UserRateBoundariesException::class);

        $maxVote = $minVote = 10;
        new UserRate($maxVote, $minVote, 2, 7);
    }

    /**
     * @group unit
     * @group areyounormis
     * @group user_rate
     */
    public function testConstructWithMaxVoteLessThanMinVote(): void
    {
        self::expectException(UserRateBoundariesException::class);

        $maxVote = 10;
        $minVote = 10.001;
        new UserRate($maxVote, $minVote, 2, 7);
    }

    /**
     * @group unit
     * @group areyounormis
     * @group user_rate
     */
    public function testConstructWithAvgVoteMoreThanMaxVote(): void
    {
        self::expectException(UserRateVoteException::class);

        $maxVote = 10;
        $avgVote = 10.001;
        new UserRate($maxVote, 0, $avgVote, 7);
    }

    /**
     * @group unit
     * @group areyounormis
     * @group user_rate
     */
    public function testConstructWithAvgVoteLessThanMinVote(): void
    {
        self::expectException(UserRateVoteException::class);

        $minVote = 0;
        $avgVote = -0.001;
        new UserRate(10, $minVote, $avgVote, 7);
    }

    /**
     * @group unit
     * @group areyounormis
     * @group user_rate
     */
    public function testConstructWithUserVoteMoreThanMaxVote(): void
    {
        self::expectException(UserRateVoteException::class);

        $maxVote = 10;
        $userVote = 10.001;
        new UserRate($maxVote, 0, 2, $userVote);
    }

    /**
     * @group unit
     * @group areyounormis
     * @group user_rate
     */
    public function testConstructWithUserVoteLessThanMinVote(): void
    {
        self::expectException(UserRateVoteException::class);

        $minVote = 0;
        $userVote = 10.001;
        new UserRate(10, $minVote, 2, $userVote);
    }

    /**
     * @group unit
     * @group areyounormis
     * @group user_rate
     */
    public function testConstructGetWithValidArguments(): void
    {
        $classUnderTest = new UserRate(
            $maxVote = 10,
            $minVote = 0,
            $avgVote = 2,
            $userVote = 7,
        );

        self::assertEquals($maxVote, $classUnderTest->getMaxVote());
        self::assertEquals($minVote, $classUnderTest->getMinVote());
        self::assertEquals($avgVote, $classUnderTest->getAvgVote());
        self::assertEquals($userVote, $classUnderTest->getUserVote());
    }

    /**
     * @group unit
     * @group areyounormis
     * @group user_rate
     */
    public function testConstructGetValidDiffsRange(): void
    {
        $classUnderTest = new UserRate($maxVote = 10, $minVote = 0, 2, 7);

        self::assertGreaterThan(0, $classUnderTest->getMaxDiff());

        self::assertGreaterThanOrEqual($minVote, $classUnderTest->getAbsoluteDiff());
        self::assertLessThanOrEqual($maxVote, $classUnderTest->getAbsoluteDiff());

        self::assertGreaterThanOrEqual(-1, $classUnderTest->getRelativeDiff());
        self::assertLessThanOrEqual(1, $classUnderTest->getRelativeDiff());

        self::assertGreaterThanOrEqual(0, $classUnderTest->getModuleRelativeDiff());
        self::assertLessThanOrEqual(1, $classUnderTest->getModuleRelativeDiff());
    }

    /**
     * @group unit
     * @group areyounormis
     * @group user_rate
     */
    public function testConstructGetAvgVoteEqualsUserVote(): void
    {
        $avgVote = $userVote = 5;
        $classUnderTest = new UserRate(10, 0, $avgVote, $userVote);

        self::assertEquals(0, $classUnderTest->getAbsoluteDiff());
        self::assertEquals(0, $classUnderTest->getRelativeDiff());
        self::assertEquals(0, $classUnderTest->getModuleRelativeDiff());
    }
}
