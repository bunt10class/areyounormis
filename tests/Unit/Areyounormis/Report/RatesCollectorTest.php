<?php

declare(strict_types=1);

namespace Tests\Unit\Areyounormis\Report;

use Areyounormis\Report\RatesCollector;
use Areyounormis\UserMovie\UserMovieRates;
use PHPUnit\Framework\TestCase;
use Tests\Unit\Areyounormis\Factories\UserMovieRateFactory;

class RatesCollectorTest extends TestCase
{
    protected RatesCollector $classUnderTest;

    protected UserMovieRates $overRates;
    protected UserMovieRates $normRates;
    protected UserMovieRates $underRates;

    protected UserMovieRateFactory $factory;

    public function setUp(): void
    {
        parent::setUp();

        $this->classUnderTest = new RatesCollector();

        $this->factory = new UserMovieRateFactory();

        $this->overRates = $this->factory->makeEmptyUserMovieRates();
        $this->normRates = $this->factory->makeEmptyUserMovieRates();
        $this->underRates = $this->factory->makeEmptyUserMovieRates();
    }

    /**
     * @group unit
     * @group areyounormis
     * @group rates_collector
     */
    public function testCollectUserRatesWithoutUserMovieRates(): void
    {
        $userMovieRates = $this->factory->makeEmptyUserMovieRates();

        $userRates = $this->classUnderTest->collectUserRates(
            $userMovieRates,
            $this->overRates,
            $this->normRates,
            $this->underRates,
        );

        self::assertEmpty($this->overRates->getUserMovieRates());
        self::assertEmpty($this->normRates->getUserMovieRates());
        self::assertEmpty($this->underRates->getUserMovieRates());
        self::assertEmpty($userRates->getUserRates());
    }

    /**
     * @group unit
     * @group areyounormis
     * @group rates_collector
     */
    public function testCollectUserRatesWithOverRate(): void
    {
        $userMovieRates = $this->factory->makeEmptyUserMovieRates();
        $userMovieRates->addOne($this->factory->makeUserMovieRate([
            'avg_vote' => 0,
            'user_vote' => 10,
        ]));

        $userRates = $this->classUnderTest->collectUserRates(
            $userMovieRates,
            $this->overRates,
            $this->normRates,
            $this->underRates,
        );

        self::assertCount(1, $this->overRates->getUserMovieRates());
        self::assertEmpty($this->normRates->getUserMovieRates());
        self::assertEmpty($this->underRates->getUserMovieRates());
        self::assertCount(1, $userRates->getUserRates());
    }

    /**
     * @group unit
     * @group areyounormis
     * @group rates_collector
     */
    public function testCollectUserRatesWithNormRates(): void
    {
        $userMovieRates = $this->factory->makeEmptyUserMovieRates();
        $userMovieRates->addOne($this->factory->makeUserMovieRate([
            'avg_vote' => 5,
            'user_vote' => 5.1,
        ]));
        $userMovieRates->addOne($this->factory->makeUserMovieRate([
            'avg_vote' => 5,
            'user_vote' => 5,
        ]));
        $userMovieRates->addOne($this->factory->makeUserMovieRate([
            'avg_vote' => 5,
            'user_vote' => 4.9,
        ]));

        $userRates = $this->classUnderTest->collectUserRates(
            $userMovieRates,
            $this->overRates,
            $this->normRates,
            $this->underRates,
        );

        self::assertEmpty($this->overRates->getUserMovieRates());
        self::assertCount(3, $this->normRates->getUserMovieRates());
        self::assertEmpty($this->underRates->getUserMovieRates());
        self::assertCount(3, $userRates->getUserRates());
    }

    /**
     * @group unit
     * @group areyounormis
     * @group rates_collector
     */
    public function testCollectUserRatesWithUnderRate(): void
    {
        $userMovieRates = $this->factory->makeEmptyUserMovieRates();
        $userMovieRates->addOne($this->factory->makeUserMovieRate([
            'avg_vote' => 10,
            'user_vote' => 0,
        ]));

        $userRates = $this->classUnderTest->collectUserRates(
            $userMovieRates,
            $this->overRates,
            $this->normRates,
            $this->underRates,
        );

        self::assertEmpty($this->overRates->getUserMovieRates());
        self::assertEmpty($this->normRates->getUserMovieRates());
        self::assertCount(1, $this->underRates->getUserMovieRates());
        self::assertCount(1, $userRates->getUserRates());
    }

    /**
     * @group unit
     * @group areyounormis
     * @group rates_collector
     */
    public function testCollectUserRatesWithNoAnyRates(): void
    {
        $userMovieRates = $this->factory->makeEmptyUserMovieRates();
        $userMovieRates->addOne($this->factory->makeUserMovieRate([
            'avg_vote' => 5,
            'user_vote' => 7,
        ]));
        $userMovieRates->addOne($this->factory->makeUserMovieRate([
            'avg_vote' => 5,
            'user_vote' => 3,
        ]));

        $userRates = $this->classUnderTest->collectUserRates(
            $userMovieRates,
            $this->overRates,
            $this->normRates,
            $this->underRates,
        );

        self::assertEmpty($this->overRates->getUserMovieRates());
        self::assertEmpty($this->normRates->getUserMovieRates());
        self::assertEmpty($this->underRates->getUserMovieRates());
        self::assertCount(2, $userRates->getUserRates());
    }

    /**
     * @group unit
     * @group areyounormis
     * @group rates_collector
     */
    public function testCollectUserRatesWithVariousRates(): void
    {
        $userMovieRates = $this->factory->makeEmptyUserMovieRates();
        $userMovieRates->addOne($this->factory->makeUserMovieRate([
            'avg_vote' => 1.23,
            'user_vote' => 9.87,
        ]));
        $userMovieRates->addOne($this->factory->makeUserMovieRate([
            'avg_vote' => 5.6,
            'user_vote' => 5.7,
        ]));
        $userMovieRates->addOne($this->factory->makeUserMovieRate([
            'avg_vote' => 9.87,
            'user_vote' => 1.23,
        ]));

        $userRates = $this->classUnderTest->collectUserRates(
            $userMovieRates,
            $this->overRates,
            $this->normRates,
            $this->underRates,
        );

        self::assertCount(1, $this->overRates->getUserMovieRates());
        self::assertCount(1, $this->normRates->getUserMovieRates());
        self::assertCount(1, $this->underRates->getUserMovieRates());
        self::assertCount(3, $userRates->getUserRates());
    }
}
