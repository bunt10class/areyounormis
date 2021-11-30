<?php

declare(strict_types=1);

namespace Tests\Unit\Areyounormis\UserMovie;

use Areyounormis\UserMovie\UserMovieRateFactory;
use Kinopoisk\UserMoviesDto;
use PHPUnit\Framework\TestCase;
use Tests\Unit\Kinopoisk\Factories\UserMovieDtoFactory;

class UserMovieRateFactoryKinopoiskTest extends TestCase
{
    protected UserMovieDtoFactory $userMovieDtoFactory;

    protected function setUp(): void
    {
        parent::setUp();

        $this->userMovieDtoFactory = new UserMovieDtoFactory();
    }

    /**
     * @group unit
     * @group areyounormis
     * @group user_movie_rate_factory
     */
    public function testMakeFromKinopoiskDto(): void
    {
        $ruName = 'некоторое имя';
        $enName = 'some name';
        $link = 'https://some_url';
        $kpVote = 3.5;
        $userVote = 8;
        $relatedRate = ($userVote - $kpVote) / 9;
        $userMovieDto = $this->userMovieDtoFactory->makeUserMovieDto([
            'ru_name' => $ruName,
            'en_name' => $enName,
            'link' => $link,
            'kp_vote' => $kpVote,
            'user_vote' => $userVote,
        ]);

        $result = UserMovieRateFactory::makeFromKinopoiskDto($userMovieDto);

        self::assertEquals($ruName, $result->getMovie()->getRuName());
        self::assertEquals($enName, $result->getMovie()->getEnName());
        self::assertEquals($link, $result->getMovie()->getLink());
        self::assertEquals((string)$kpVote, $result->getMovie()->getVote());
        self::assertEquals((string)$userVote, $result->getUserVote());
        self::assertEquals($relatedRate, $result->getRelativeRate()->getValue());
    }

    /**
     * @group unit
     * @group areyounormis
     * @group user_movie_rate_factory
     */
    public function testMakeFromKinopoiskDtoWithKpVoteInt(): void
    {
        $kpVote = 5;
        $userMovieDto = $this->userMovieDtoFactory->makeUserMovieDto([
            'kp_vote' => $kpVote,
        ]);

        $result = UserMovieRateFactory::makeFromKinopoiskDto($userMovieDto);

        self::assertEquals((string)$kpVote, $result->getMovie()->getVote());
    }

    /**
     * @group unit
     * @group areyounormis
     * @group user_movie_rate_factory
     */
    public function testMakeFromKinopoiskDtoWithKpVoteAboveBoundary(): void
    {
        $userMovieDto = $this->userMovieDtoFactory->makeUserMovieDto([
            'kp_vote' => 10.001,
        ]);

        $result = UserMovieRateFactory::makeFromKinopoiskDto($userMovieDto);

        self::assertNull($result);
    }

    /**
     * @group unit
     * @group areyounormis
     * @group user_movie_rate_factory
     */
    public function testMakeFromKinopoiskDtoWithKpVoteBelowBoundary(): void
    {
        $userMovieDto = $this->userMovieDtoFactory->makeUserMovieDto([
            'kp_vote' => 0.999,
        ]);

        $result = UserMovieRateFactory::makeFromKinopoiskDto($userMovieDto);

        self::assertNull($result);
    }

    /**
     * @group unit
     * @group areyounormis
     * @group user_movie_rate_factory
     */
    public function testMakeFromKinopoiskDtoWithUserVoteInt(): void
    {
        $userVote = 5;
        $userMovieDto = $this->userMovieDtoFactory->makeUserMovieDto([
            'user_vote' => $userVote,
        ]);

        $result = UserMovieRateFactory::makeFromKinopoiskDto($userMovieDto);

        self::assertEquals((string)$userVote, $result->getUserVote());
    }

    /**
     * @group unit
     * @group areyounormis
     * @group user_movie_rate_factory
     */
    public function testMakeCollectionFromKinopoiskDtoCollection(): void
    {
        $ruName = 'некоторое имя';
        $enName = 'some name';
        $link = 'https://some_url';
        $kpVote = 3.5;
        $userVote = 8;
        $relatedRate = ($userVote - $kpVote) / 9;
        $userMovieDto = $this->userMovieDtoFactory->makeUserMovieDto([
            'ru_name' => $ruName,
            'en_name' => $enName,
            'link' => $link,
            'kp_vote' => $kpVote,
            'user_vote' => $userVote,
        ]);
        $userMoviesDto = new UserMoviesDto();
        $userMoviesDto->addOne($userMovieDto);

        $result = UserMovieRateFactory::makeCollectionFromKinopoiskDtoCollection($userMoviesDto);

        $userMovieRate = $result->getUserMovieRates()[0];
        self::assertEquals($ruName, $userMovieRate->getMovie()->getRuName());
        self::assertEquals($enName, $userMovieRate->getMovie()->getEnName());
        self::assertEquals($link, $userMovieRate->getMovie()->getLink());
        self::assertEquals((string)$kpVote, $userMovieRate->getMovie()->getVote());
        self::assertEquals((string)$userVote, $userMovieRate->getUserVote());
        self::assertEquals($relatedRate, $userMovieRate->getRelativeRate()->getValue());
    }

    /**
     * @group unit
     * @group areyounormis
     * @group user_movie_rate_factory
     */
    public function testMakeCollectionFromKinopoiskDtoCollectionWithSomeDto(): void
    {
        $userMoviesDto = new UserMoviesDto();
        $userMoviesDto->addOne($this->userMovieDtoFactory->makeUserMovieDto());
        $userMoviesDto->addOne($this->userMovieDtoFactory->makeUserMovieDto());
        $userMoviesDto->addOne($this->userMovieDtoFactory->makeUserMovieDto());

        $result = UserMovieRateFactory::makeCollectionFromKinopoiskDtoCollection($userMoviesDto);

        self::assertCount(3, $result->getUserMovieRates());
    }

    /**
     * @group unit
     * @group areyounormis
     * @group user_movie_rate_factory
     */
    public function testMakeCollectionFromKinopoiskDtoCollectionWithInvalidUserMovieDtoData(): void
    {
        $userMovieDto = $this->userMovieDtoFactory->makeUserMovieDto([
            'kp_vote' => 0,
        ]);
        $userMoviesDto = new UserMoviesDto();
        $userMoviesDto->addOne($userMovieDto);

        $result = UserMovieRateFactory::makeCollectionFromKinopoiskDtoCollection($userMoviesDto);

        self::assertEmpty($result->getUserMovieRates());
    }
}
