<?php

declare(strict_types=1);

namespace Tests\Unit\Kinopoisk\Mocks;

use DOMElement;
use Kinopoisk\UserMoviesDto;
use Kinopoisk\WebService\UserMoviesPageParser\MovieListParser;
use Tests\Unit\Kinopoisk\Factories\UserMovieDtoFactory;

class MovieListParserMock extends MovieListParser
{
    protected UserMoviesDto $userMoviesDto;

    public function __construct(int $movieNumber = 0)
    {
        $this->userMoviesDto = new UserMoviesDto();

        $userMovieDtoFactory = new UserMovieDtoFactory();
        for ($i = 0; $i < $movieNumber; $i++) {
            $this->userMoviesDto->addOne($userMovieDtoFactory->makeUserMovieDto());
        }
    }

    public function getUserMoviesDto(DOMElement $moviesList): UserMoviesDto
    {
        return $this->userMoviesDto;
    }
}