<?php

declare(strict_types=1);

namespace Tests\Unit\Kinopoisk\WebService\UserMoviesPageParser;

use Kinopoisk\WebService\UserMoviesPageParser\MovieListParser;
use Tests\Unit\Kinopoisk\Factories\HtmlMoviesFactory;

class MovieListParserTest extends ParserMain
{
    protected MovieListParser $classUnderTest;
    protected HtmlMoviesFactory $htmlMoviesFactory;

    public function setUp(): void
    {
        parent::setUp();

        $this->classUnderTest = new MovieListParser();
        $this->htmlMoviesFactory = new HtmlMoviesFactory();
    }

    /**
     * @group unit
     * @group kinopoisk
     * @group movie_list_parser
     */
    public function testGetMoviesWithNotHtml(): void
    {
        $element = $this->getDomElement('not_html');

        $result = $this->classUnderTest->getUserMoviesDto($element);

        self::assertTrue($result->isEmpty());
    }

    /**
     * @group unit
     * @group kinopoisk
     * @group movie_list_parser
     */
    public function testGetMoviesWithoutMoviesHtml(): void
    {
        $element = $this->getDomElement('<div>some_value</div>');

        $result = $this->classUnderTest->getUserMoviesDto($element);

        self::assertTrue($result->isEmpty());
    }

    /**
     * @group unit
     * @group kinopoisk
     * @group movie_list_parser
     */
    public function testGetMoviesWithTwoMovies(): void
    {
        $movies = [
            ['ru_name' => 'some_name'],
            ['ru_name' => 'another_name'],
        ];
        $html = $this->htmlMoviesFactory->getMovieElements($movies);
        $element = $this->getDomElement($html);

        $result = $this->classUnderTest->getUserMoviesDto($element);

        self::assertCount(count($movies), $result->getItems());
    }

    /**
     * @group unit
     * @group kinopoisk
     * @group movie_list_parser
     */
    public function testGetMoviesGetValidMovieData(): void
    {
        $ruName = 'некоторое имя';
        $enName = 'some name';
        $link = 'https://some_url';
        $kpVote = 1.234;
        $voteNumber = 123;
        $durationInMinutes = 456;
        $voteDate = '01.01.1990, 00:00';
        $userVote = 5;
        $html = $this->htmlMoviesFactory->getMovieElement([
            'ru_name' => $ruName,
            'en_name' => $enName,
            'link' => $link,
            'kp_vote' => $kpVote,
            'vote_number' => $voteNumber,
            'duration_in_minutes' => $durationInMinutes,
            'vote_date' => $voteDate,
            'user_vote' => $userVote,
        ]);
        $element = $this->getDomElement($html);

        $result = $this->classUnderTest->getUserMoviesDto($element);

        $userMovie = $result->getItems()[0];
        self::assertEquals($ruName, $userMovie->getRuName());
        self::assertEquals($enName, $userMovie->getEnName());
        self::assertEquals($link, $userMovie->getLink());
        self::assertEquals($kpVote, $userMovie->getKpVote());
        self::assertEquals($voteNumber, $userMovie->getVoteNumber());
        self::assertEquals($durationInMinutes, $userMovie->getDurationInMinutes());
        self::assertEquals($voteDate, $userMovie->getVoteDate());
        self::assertEquals($userVote, $userMovie->getUserVote());
    }
}
