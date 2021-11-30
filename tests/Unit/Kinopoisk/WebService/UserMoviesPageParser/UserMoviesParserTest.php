<?php

declare(strict_types=1);

namespace Tests\Unit\Kinopoisk\WebService\UserMoviesPageParser;

use Kinopoisk\WebService\UserMoviesPageParser\UserMoviesParser;
use Tests\Unit\Kinopoisk\Mocks\CaptchaDetectorMock;
use Tests\Unit\Kinopoisk\Mocks\MovieListParserMock;
use Tests\Unit\Kinopoisk\Mocks\MovieListSearcherMock;

class UserMoviesParserTest extends ParserMain
{
    /**
     * @group unit
     * @group kinopoisk
     * @group user_movies_parser
     */
    public function testGetMoviesWithCaptcha(): void
    {
        $classUnderTest = new UserMoviesParser(
            new CaptchaDetectorMock(true),
            new MovieListSearcherMock(),
            new MovieListParserMock(),
        );

        $result = $classUnderTest->parseUserMoviesPage('');

        self::assertTrue($result->isCaptcha());
        self::assertNull($result->getUserMoviesDto());
    }

    /**
     * @group unit
     * @group kinopoisk
     * @group user_movies_parser
     */
    public function testGetMoviesWithoutMovieList(): void
    {
        $classUnderTest = new UserMoviesParser(
            new CaptchaDetectorMock(),
            new MovieListSearcherMock(false),
            new MovieListParserMock(),
        );

        $result = $classUnderTest->parseUserMoviesPage('');

        self::assertFalse($result->isCaptcha());
        self::assertNull($result->getUserMoviesDto());
    }

    /**
     * @group unit
     * @group kinopoisk
     * @group user_movies_parser
     */
    public function testGetMoviesWithNoOneMovie(): void
    {
        $classUnderTest = new UserMoviesParser(
            new CaptchaDetectorMock(),
            new MovieListSearcherMock(),
            new MovieListParserMock(),
        );

        $result = $classUnderTest->parseUserMoviesPage('');

        self::assertFalse($result->isCaptcha());
        self::assertNotNull($result->getUserMoviesDto());
        self::assertTrue($result->getUserMoviesDto()->isEmpty());
    }

    /**
     * @group unit
     * @group kinopoisk
     * @group user_movies_parser
     */
    public function testGetMoviesWithSomeMovies(): void
    {
        $movieNumber = 3;
        $classUnderTest = new UserMoviesParser(
            new CaptchaDetectorMock(),
            new MovieListSearcherMock(),
            new MovieListParserMock($movieNumber),
        );

        $result = $classUnderTest->parseUserMoviesPage('');

        self::assertFalse($result->isCaptcha());
        self::assertNotNull($result->getUserMoviesDto());
        self::assertCount($movieNumber, $result->getUserMoviesDto()->getUserMovies());
    }
}
