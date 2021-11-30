<?php

declare(strict_types=1);

namespace Tests\Unit\Areyounormis\Report;

use Areyounormis\Report\RatesCollector;
use Areyounormis\UserMovie\RelativeRates;
use Areyounormis\UserMovie\UserMovieRates;
use PHPUnit\Framework\TestCase;
use Tests\Unit\Areyounormis\Factories\UserMovieRateFactory;

class RatesCollectorTest extends TestCase
{
    protected RatesCollector $classUnderTest;

    protected UserMovieRates $overRateMovie;
    protected UserMovieRates $normRateMovies;
    protected UserMovieRates $underRateMovies;
    protected RelativeRates $relativeRates;

    protected UserMovieRateFactory $factory;

    public function setUp(): void
    {
        parent::setUp();

        $this->classUnderTest = new RatesCollector();

        $this->overRateMovie = new UserMovieRates();
        $this->normRateMovies = new UserMovieRates();
        $this->underRateMovies = new UserMovieRates();
        $this->relativeRates = new RelativeRates();

        $this->factory = new UserMovieRateFactory();
    }

    /**
     * @group unit
     * @group areyounormis
     * @group rates_collector
     */
    public function testCollectRatesWithoutUserMovieRates(): void
    {
        $userMovieRates = new UserMovieRates();

        $this->classUnderTest->collectRates(
            $userMovieRates,
            $this->overRateMovie,
            $this->normRateMovies,
            $this->underRateMovies,
            $this->relativeRates,
        );

        self::assertEmpty($this->overRateMovie->getUserMovieRates());
        self::assertEmpty($this->normRateMovies->getUserMovieRates());
        self::assertEmpty($this->underRateMovies->getUserMovieRates());
        self::assertEmpty($this->relativeRates->getRelativeRates());
    }

    /**
     * @group unit
     * @group areyounormis
     * @group rates_collector
     */
    public function testCollectRatesWithOverRatesMovies(): void
    {
        $userMovieRates = new UserMovieRates();
        $userMovieRates->addOne($this->factory->makeUserMovieRate(['relative_rate' => 0.7]));
        $userMovieRates->addOne($this->factory->makeUserMovieRate(['relative_rate' => 0.9]));

        $this->classUnderTest->collectRates(
            $userMovieRates,
            $this->overRateMovie,
            $this->normRateMovies,
            $this->underRateMovies,
            $this->relativeRates,
        );

        self::assertCount(2, $this->overRateMovie->getUserMovieRates());
        self::assertEmpty($this->normRateMovies->getUserMovieRates());
        self::assertEmpty($this->underRateMovies->getUserMovieRates());
        self::assertCount(2, $this->relativeRates->getRelativeRates());
    }

    /**
     * @group unit
     * @group areyounormis
     * @group rates_collector
     */
    public function testCollectRatesWithNormRatesMovies(): void
    {
        $userMovieRates = new UserMovieRates();
        $userMovieRates->addOne($this->factory->makeUserMovieRate(['relative_rate' => -0.02]));
        $userMovieRates->addOne($this->factory->makeUserMovieRate(['relative_rate' => 0.03]));

        $this->classUnderTest->collectRates(
            $userMovieRates,
            $this->overRateMovie,
            $this->normRateMovies,
            $this->underRateMovies,
            $this->relativeRates,
        );

        self::assertEmpty($this->overRateMovie->getUserMovieRates());
        self::assertCount(2, $this->normRateMovies->getUserMovieRates());
        self::assertEmpty($this->underRateMovies->getUserMovieRates());
        self::assertCount(2, $this->relativeRates->getRelativeRates());
    }

    /**
     * @group unit
     * @group areyounormis
     * @group rates_collector
     */
    public function testCollectRatesWithUnderRatesMovies(): void
    {
        $userMovieRates = new UserMovieRates();
        $userMovieRates->addOne($this->factory->makeUserMovieRate(['relative_rate' => -0.95]));
        $userMovieRates->addOne($this->factory->makeUserMovieRate(['relative_rate' => -0.8]));

        $this->classUnderTest->collectRates(
            $userMovieRates,
            $this->overRateMovie,
            $this->normRateMovies,
            $this->underRateMovies,
            $this->relativeRates,
        );

        self::assertEmpty($this->overRateMovie->getUserMovieRates());
        self::assertEmpty($this->normRateMovies->getUserMovieRates());
        self::assertCount(2, $this->underRateMovies->getUserMovieRates());
        self::assertCount(2, $this->relativeRates->getRelativeRates());
    }

    /**
     * @group unit
     * @group areyounormis
     * @group rates_collector
     */
    public function testCollectRatesWithBoundaryRatesMovies(): void
    {
        $userMovieRates = new UserMovieRates();
        $userMovieRates->addOne($this->factory->makeUserMovieRate(['relative_rate' => -1]));
        $userMovieRates->addOne($this->factory->makeUserMovieRate(['relative_rate' => 0]));
        $userMovieRates->addOne($this->factory->makeUserMovieRate(['relative_rate' => 1]));

        $this->classUnderTest->collectRates(
            $userMovieRates,
            $this->overRateMovie,
            $this->normRateMovies,
            $this->underRateMovies,
            $this->relativeRates,
        );

        self::assertCount(1, $this->overRateMovie->getUserMovieRates());
        self::assertCount(1, $this->normRateMovies->getUserMovieRates());
        self::assertCount(1, $this->underRateMovies->getUserMovieRates());
    }

    /**
     * @group unit
     * @group areyounormis
     * @group rates_collector
     */
    public function testCollectRatesWithVariousRatesMovies(): void
    {
        $userMovieRates = new UserMovieRates();
        $userMovieRates->addOne($this->factory->makeUserMovieRate(['relative_rate' => -0.91]));
        $userMovieRates->addOne($this->factory->makeUserMovieRate(['relative_rate' => -0.77]));
        $userMovieRates->addOne($this->factory->makeUserMovieRate(['relative_rate' => -0.68]));
        $userMovieRates->addOne($this->factory->makeUserMovieRate(['relative_rate' => -0.01]));
        $userMovieRates->addOne($this->factory->makeUserMovieRate(['relative_rate' => 0.02]));
        $userMovieRates->addOne($this->factory->makeUserMovieRate(['relative_rate' => 0.83]));

        $this->classUnderTest->collectRates(
            $userMovieRates,
            $this->overRateMovie,
            $this->normRateMovies,
            $this->underRateMovies,
            $this->relativeRates,
        );

        self::assertCount(1, $this->overRateMovie->getUserMovieRates());
        self::assertCount(2, $this->normRateMovies->getUserMovieRates());
        self::assertCount(3, $this->underRateMovies->getUserMovieRates());
        self::assertCount(6, $this->relativeRates->getRelativeRates());
    }
}
