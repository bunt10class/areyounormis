<?php

declare(strict_types=1);

namespace Tests\Unit\Areyounormis\Domain\Vote\Factories;

use Areyounormis\Domain\Vote\Factories\VoteFactory;
use Areyounormis\Domain\Vote\Exceptions\VoteOutOfBoundariesException;
use PHPUnit\Framework\TestCase;
use Tests\Unit\Areyounormis\Factories\VoteSystemFactory;

class VoteFactoryTest extends TestCase
{
    /**
     * @group unit
     * @group areyounormis
     * @group vote
     * @group vote_system_factory
     */
    public function testMakeUserVoteMoreThanSiteVote(): void
    {
        $result = VoteFactory::make(VoteSystemFactory::getDefault(), 7, 2);

        self::assertEquals(7, $result->getUserVote());
        self::assertEquals(2, $result->getResourceVote());
        self::assertEquals(5, $result->getAbsoluteDiff());
        self::assertEquals(0.5, $result->getRelativeDiff());
        self::assertEquals(0.5, $result->getModuleRelativeDiff());
    }

    /**
     * @group unit
     * @group areyounormis
     * @group vote
     * @group vote_system_factory
     */
    public function testMakeUserVoteLessThanSiteVote(): void
    {
        $result = VoteFactory::make(VoteSystemFactory::getDefault(), 2, 7);

        self::assertEquals(2, $result->getUserVote());
        self::assertEquals(7, $result->getResourceVote());
        self::assertEquals(-5, $result->getAbsoluteDiff());
        self::assertEquals(-0.5, $result->getRelativeDiff());
        self::assertEquals(0.5, $result->getModuleRelativeDiff());
    }

    /**
     * @group unit
     * @group areyounormis
     * @group vote
     * @group vote_system_factory
     */
    public function testMakeFloatArguments(): void
    {
        $result = VoteFactory::make(VoteSystemFactory::getDefault(), 7.001, 2.001);

        self::assertEquals(7.001, $result->getUserVote());
        self::assertEquals(2.001, $result->getResourceVote());
        self::assertEquals(5, $result->getAbsoluteDiff());
        self::assertEquals(0.5, $result->getRelativeDiff());
        self::assertEquals(0.5, $result->getModuleRelativeDiff());
    }

    /**
     * @group unit
     * @group areyounormis
     * @group vote
     * @group vote_system_factory
     */
    public function testMakeFloatArgumentsWithPrecisionMoreThan3(): void
    {
        $result = VoteFactory::make(VoteSystemFactory::getDefault(), 7.0001, 1.9999);

        self::assertEquals(7, $result->getUserVote());
        self::assertEquals(2, $result->getResourceVote());
    }

    /**
     * @group unit
     * @group areyounormis
     * @group vote
     * @group vote_system_factory
     */
    public function testMakeUserVoteMoreThanMax(): void
    {
        self::expectException(VoteOutOfBoundariesException::class);

        VoteFactory::make(VoteSystemFactory::getDefault(), 11, 2);
    }

    /**
     * @group unit
     * @group areyounormis
     * @group vote
     * @group vote_system_factory
     */
    public function testMakeUserVoteLessThanMin(): void
    {
        self::expectException(VoteOutOfBoundariesException::class);

        VoteFactory::make(VoteSystemFactory::getDefault(), -1, 2);
    }

    /**
     * @group unit
     * @group areyounormis
     * @group vote
     * @group vote_system_factory
     */
    public function testMakeSiteVoteMoreThanMax(): void
    {
        self::expectException(VoteOutOfBoundariesException::class);

        VoteFactory::make(VoteSystemFactory::getDefault(), 7, 11);
    }

    /**
     * @group unit
     * @group areyounormis
     * @group vote
     * @group vote_system_factory
     */
    public function testMakeSiteVoteLessThanMin(): void
    {
        self::expectException(VoteOutOfBoundariesException::class);

        VoteFactory::make(VoteSystemFactory::getDefault(), 7, -1);
    }
}
