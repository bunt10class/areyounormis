<?php

declare(strict_types=1);

namespace Tests\Unit\Areyounormis\Vote;

use Areyounormis\Vote\Exceptions\VoteSystemException;
use Areyounormis\Vote\VoteSystemFactory;
use PHPUnit\Framework\TestCase;

class VoteSystemFactoryTest extends TestCase
{
    /**
     * @group unit
     * @group areyounormis
     * @group vote
     * @group vote_system_factory
     */
    public function testMake(): void
    {
        $result = VoteSystemFactory::make(10, 0, 1);

        self::assertEquals(10, $result->getMax());
        self::assertEquals(0, $result->getMin());
        self::assertEquals(10, $result->getDiff());
        self::assertEquals(1, $result->getStep());
        self::assertEquals(0.1, $result->getRelativeStep());
    }

    /**
     * @group unit
     * @group areyounormis
     * @group vote
     * @group vote_system_factory
     */
    public function testMakeFloatArguments(): void
    {
        $result = VoteSystemFactory::make($max = 10.2, $min = 0.3, $step = 0.1);

        self::assertEquals($max, $result->getMax());
        self::assertEquals($min, $result->getMin());
        self::assertEquals($step, $result->getStep());
    }

    /**
     * @group unit
     * @group areyounormis
     * @group vote
     * @group vote_system_factory
     */
    public function testMakeFloatArgumentsWithPrecisionMoreThan3(): void
    {
        $result = VoteSystemFactory::make(10.0001, 0.0001, 1);

        self::assertEquals(10, $result->getMax());
        self::assertEquals(0, $result->getMin());
        self::assertEquals(1, $result->getStep());
    }

    /**
     * @group unit
     * @group areyounormis
     * @group vote
     * @group vote_system_factory
     */
    public function testMakeMaxLessThanZero(): void
    {
        self::expectException(VoteSystemException::class);

        VoteSystemFactory::make(-1, 0, 1);
    }

    /**
     * @group unit
     * @group areyounormis
     * @group vote
     * @group vote_system_factory
     */
    public function testMakeMinLessThanZero(): void
    {
        self::expectException(VoteSystemException::class);

        VoteSystemFactory::make(10, -1, 1);
    }

    /**
     * @group unit
     * @group areyounormis
     * @group vote
     * @group vote_system_factory
     */
    public function testMakeStepEqualsZero(): void
    {
        self::expectException(VoteSystemException::class);

        VoteSystemFactory::make(10, 0, 0);
    }

    /**
     * @group unit
     * @group areyounormis
     * @group vote
     * @group vote_system_factory
     */
    public function testMakeStepLessThanZero(): void
    {
        self::expectException(VoteSystemException::class);

        VoteSystemFactory::make(10, 0, -1);
    }

    /**
     * @group unit
     * @group areyounormis
     * @group vote
     * @group vote_system_factory
     */
    public function testMakeMaxLessThanMin(): void
    {
        self::expectException(VoteSystemException::class);

        VoteSystemFactory::make(10, 11, 1);
    }

    /**
     * @group unit
     * @group areyounormis
     * @group vote
     * @group vote_system_factory
     */
    public function testMakeMaxLessThanStep(): void
    {
        self::expectException(VoteSystemException::class);

        VoteSystemFactory::make(10, 0, 11);
    }

    /**
     * @group unit
     * @group areyounormis
     * @group vote
     * @group vote_system_factory
     */
    public function testMakeStepNotMultiplyToDiff(): void
    {
        self::expectException(VoteSystemException::class);

        VoteSystemFactory::make(10, 0, 1.1);
    }

    /**
     * @group unit
     * @group areyounormis
     * @group vote
     * @group vote_system_factory
     */
    public function testMakeForKinopoisk(): void
    {
        $result = VoteSystemFactory::makeForKinopoisk();

        self::assertEquals(10, $result->getMax());
        self::assertEquals(1, $result->getMin());
        self::assertEquals(1, $result->getStep());
    }
}
