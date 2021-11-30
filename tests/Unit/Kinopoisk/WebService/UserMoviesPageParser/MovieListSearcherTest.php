<?php

declare(strict_types=1);

namespace Tests\Unit\Kinopoisk\WebService\UserMoviesPageParser;

use Kinopoisk\WebService\UserMoviesPageParser\MovieListSearcher;
use Tests\Unit\Kinopoisk\Factories\HtmlMoviesFactory;

class MovieListSearcherTest extends ParserMain
{
    protected MovieListSearcher $classUnderTest;
    protected HtmlMoviesFactory $htmlMoviesFactory;

    public function setUp(): void
    {
        parent::setUp();

        $this->classUnderTest = new MovieListSearcher();
        $this->htmlMoviesFactory = new HtmlMoviesFactory();
    }

    /**
     * @group unit
     * @group kinopoisk
     * @group movie_list_searcher
     */
    public function testFindByClassWithNotHtml(): void
    {
        $dom = $this->getDomDocument('not_html');

        $result = $this->classUnderTest->findByClass($dom);

        self::assertNull($result);
    }

    /**
     * @group unit
     * @group kinopoisk
     * @group movie_list_searcher
     */
    public function testFindByClassWithoutMovieListElement(): void
    {
        $dom = $this->getDomDocument('<div>some_value</div>');

        $result = $this->classUnderTest->findByClass($dom);

        self::assertNull($result);
    }

    /**
     * @group unit
     * @group kinopoisk
     * @group movie_list_searcher
     */
    public function testFindByClassWithMovieListElement(): void
    {
        $movieListValue = 'movie_list';
        $html = $this->htmlMoviesFactory->collectElement('div', ['class' => 'profileFilmsList'], $movieListValue);
        $dom = $this->getDomDocument($html);

        $result = $this->classUnderTest->findByClass($dom);

        self::assertNotNull($result);
        self::assertEquals($movieListValue, $result->nodeValue);
    }

    /**
     * @group unit
     * @group kinopoisk
     * @group movie_list_searcher
     */
    public function testFindByChildrenWithNotHtml(): void
    {
        $dom = $this->getDomDocument('not_html');

        $result = $this->classUnderTest->findByChildren($dom);

        self::assertNull($result);
    }

    /**
     * @group unit
     * @group kinopoisk
     * @group movie_list_searcher
     */
    public function testFindByChildrenWithoutMovieListElement(): void
    {
        $dom = $this->getDomDocument('<div>some_value</div>');

        $result = $this->classUnderTest->findByChildren($dom);

        self::assertNull($result);
    }

    /**
     * @group unit
     * @group kinopoisk
     * @group movie_list_searcher
     */
    public function testFindByChildrenWithMovieListElementWithoutValidLocation(): void
    {
        $html = $this->htmlMoviesFactory->collectElement('div', ['class' => 'profileFilmsList']);
        $dom = $this->getDomDocument($html);

        $result = $this->classUnderTest->findByChildren($dom);

        self::assertNull($result);
    }

    /**
     * @group unit
     * @group kinopoisk
     * @group movie_list_searcher
     */
    public function testFindByChildrenWithMovieListElementWithValidLocation(): void
    {
        $html = $this->htmlMoviesFactory->getMovieList();
        $dom = $this->getDomDocument($html);

        $result = $this->classUnderTest->findByChildren($dom);

        self::assertNotNull($result);
    }
}
