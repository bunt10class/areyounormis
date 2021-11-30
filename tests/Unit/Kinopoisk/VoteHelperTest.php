<?php

declare(strict_types=1);

namespace Tests\Unit\Kinopoisk;

use Kinopoisk\VoteHelper;
use PHPUnit\Framework\TestCase;

class VoteHelperTest extends TestCase
{
    /**
     * @group unit
     * @group kinopoisk
     * @group vote_helper
     */
    public function testIsValidVoteString(): void
    {
        $result = VoteHelper::isValidVote('1.23');

        self::assertTrue($result);
    }

    /**
     * @group unit
     * @group kinopoisk
     * @group vote_helper
     */
    public function testIsValidVoteInt(): void
    {
        $result = VoteHelper::isValidVote(5);

        self::assertTrue($result);
    }

    /**
     * @group unit
     * @group kinopoisk
     * @group vote_helper
     */
    public function testIsValidVoteFloat(): void
    {
        $result = VoteHelper::isValidVote(1.23);

        self::assertTrue($result);
    }

    /**
     * @group unit
     * @group kinopoisk
     * @group vote_helper
     */
    public function testIsValidVoteBool(): void
    {
        $result = VoteHelper::isValidVote(true);

        self::assertFalse($result);
    }

    /**
     * @group unit
     * @group kinopoisk
     * @group vote_helper
     */
    public function testIsValidVoteArray(): void
    {
        $result = VoteHelper::isValidVote(['some_array']);

        self::assertFalse($result);
    }

    /**
     * @group unit
     * @group kinopoisk
     * @group vote_helper
     */
    public function testIsValidVoteAboveBoundary(): void
    {
        $result = VoteHelper::isValidVote(10.001);

        self::assertFalse($result);
    }

    /**
     * @group unit
     * @group kinopoisk
     * @group vote_helper
     */
    public function testIsValidVoteBelowBoundary(): void
    {
        $result = VoteHelper::isValidVote(0.999);

        self::assertFalse($result);
    }
}
