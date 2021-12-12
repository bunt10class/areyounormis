<?php

declare(strict_types=1);

namespace Tests\Unit\Kinopoisk\Mocks;

use DOMElement;
use Kinopoisk\Dto\KinopoiskUserMovieList;
use Kinopoisk\WebService\UserMoviesPageParser\MovieListParser;
use Tests\Unit\Kinopoisk\Factories\KinopoiskUserMovieFactory;

class MovieListParserMock extends MovieListParser
{
    protected KinopoiskUserMovieList $userMoviesDto;

    public function __construct(int $movieNumber = 0)
    {
        $this->userMoviesDto = new KinopoiskUserMovieList();

        $userMovieDtoFactory = new KinopoiskUserMovieFactory();
        for ($i = 0; $i < $movieNumber; $i++) {
            $this->userMoviesDto->addItem($userMovieDtoFactory->make());
        }
    }

    public function getUserMoviesDto(DOMElement $moviesList): KinopoiskUserMovieList
    {
        return $this->userMoviesDto;
    }
}