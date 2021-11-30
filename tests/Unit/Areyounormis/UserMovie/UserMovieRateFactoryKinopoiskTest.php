<?php

declare(strict_types=1);

namespace Tests\Unit\Areyounormis\UserMovie;

use Areyounormis\UserMovie\UserMovieRateFactory;
use Kinopoisk\KinopoiskUserMovies;
use PHPUnit\Framework\TestCase;
use Tests\Unit\Kinopoisk\Factories\KinopoiskUserMovieFactory;

class UserMovieRateFactoryKinopoiskTest extends TestCase
{
    protected KinopoiskUserMovieFactory $factory;

    protected function setUp(): void
    {
        parent::setUp();

        $this->factory = new KinopoiskUserMovieFactory();
    }

    /**
     * @group unit
     * @group areyounormis
     * @group user_movie_rate_factory
     */
    public function testMakeFromKinopoiskUserMovies(): void
    {
        $ruName = 'некоторое имя';
        $enName = 'some name';
        $link = 'https://some_url';
        $kpVote = 2.5;
        $userVote = 7;
        $userMovie = $this->factory->makeKinopoiskUserMovie([
            'ru_name' => $ruName,
            'en_name' => $enName,
            'link' => $link,
            'kp_vote' => $kpVote,
            'user_vote' => $userVote,
        ]);

        $result = UserMovieRateFactory::makeFromKinopoiskUserMovie($userMovie);

        self::assertEquals($ruName, $result->getMovie()->getRuName());
        self::assertEquals($enName, $result->getMovie()->getEnName());
        self::assertEquals($link, $result->getMovie()->getLink());
        self::assertEquals($kpVote, $result->getUserRate()->getAvgVote());
        self::assertEquals($userVote, $result->getUserRate()->getUserVote());
    }

    /**
     * @group unit
     * @group areyounormis
     * @group user_movie_rate_factory
     */
    public function testMakeFromKinopoiskUserMoviesWithKpVoteAboveBoundary(): void
    {
        $userMovie = $this->factory->makeKinopoiskUserMovie([
            'kp_vote' => 10.001,
        ]);

        $result = UserMovieRateFactory::makeFromKinopoiskUserMovie($userMovie);

        self::assertNull($result);
    }

    /**
     * @group unit
     * @group areyounormis
     * @group user_movie_rate_factory
     */
    public function testMakeFromKinopoiskUserMoviesWithKpVoteBelowBoundary(): void
    {
        $userMovie = $this->factory->makeKinopoiskUserMovie([
            'kp_vote' => 0.999,
        ]);

        $result = UserMovieRateFactory::makeFromKinopoiskUserMovie($userMovie);

        self::assertNull($result);
    }

    /**
     * @group unit
     * @group areyounormis
     * @group user_movie_rate_factory
     */
    public function testMakeFromKinopoiskUserMoviesWithUserVoteAboveBoundary(): void
    {
        $userMovie = $this->factory->makeKinopoiskUserMovie([
            'user_vote' => 11,
        ]);

        $result = UserMovieRateFactory::makeFromKinopoiskUserMovie($userMovie);

        self::assertNull($result);
    }

    /**
     * @group unit
     * @group areyounormis
     * @group user_movie_rate_factory
     */
    public function testMakeFromKinopoiskUserMoviesWithUserVoteBelowBoundary(): void
    {
        $userMovie = $this->factory->makeKinopoiskUserMovie([
            'user_vote' => 0,
        ]);

        $result = UserMovieRateFactory::makeFromKinopoiskUserMovie($userMovie);

        self::assertNull($result);
    }

    /**
     * @group unit
     * @group areyounormis
     * @group user_movie_rate_factory
     */
    public function testMakeCollectionFromKinopoiskCollection(): void
    {
        $ruName = 'некоторое имя';
        $enName = 'some name';
        $link = 'https://some_url';
        $kpVote = 2.5;
        $userVote = 7;
        $userMovie = $this->factory->makeKinopoiskUserMovie([
            'ru_name' => $ruName,
            'en_name' => $enName,
            'link' => $link,
            'kp_vote' => $kpVote,
            'user_vote' => $userVote,
        ]);
        $userMovies = new KinopoiskUserMovies();
        $userMovies->addOne($userMovie);

        $result = UserMovieRateFactory::makeCollectionFromKinopoiskUserMovies($userMovies);

        $userMovieRate = $result->getUserMovieRates()[0];
        self::assertEquals($ruName, $userMovieRate->getMovie()->getRuName());
        self::assertEquals($enName, $userMovieRate->getMovie()->getEnName());
        self::assertEquals($link, $userMovieRate->getMovie()->getLink());
        self::assertEquals($kpVote, $userMovieRate->getUserRate()->getAvgVote());
        self::assertEquals($userVote, $userMovieRate->getUserRate()->getUserVote());
    }

    /**
     * @group unit
     * @group areyounormis
     * @group user_movie_rate_factory
     */
    public function testMakeCollectionFromKinopoiskCollectionWithSome(): void
    {
        $userMovies = $this->factory->makeKinopoiskUserMoviesWithUserMovie($number = 3);

        $result = UserMovieRateFactory::makeCollectionFromKinopoiskUserMovies($userMovies);

        self::assertCount($number, $result->getUserMovieRates());
    }

    /**
     * @group unit
     * @group areyounormis
     * @group user_movie_rate_factory
     */
    public function testMakeCollectionFromKinopoiskCollectionWithInvalidUserMovieData(): void
    {
        $userMovie = $this->factory->makeKinopoiskUserMovie([
            'kp_vote' => 0,
        ]);
        $userMovies = $this->factory->makeEmptyKinopoiskUserMovies();
        $userMovies->addOne($userMovie);

        $result = UserMovieRateFactory::makeCollectionFromKinopoiskUserMovies($userMovies);

        self::assertEmpty($result->getUserMovieRates());
    }
}
