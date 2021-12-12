<?php

declare(strict_types=1);

namespace Tests\Unit\Kinopoisk\Mocks;

use Kinopoisk\Dto\KinopoiskUserMovieList;
use Kinopoisk\WebService\UserMoviesPageParser\UserMoviesPage;
use Kinopoisk\WebService\UserMoviesPageParser\UserMoviePageParser;

class UserMoviePageParserMock extends UserMoviePageParser
{
    protected UserMoviesPage $userMoviesPage;

    public function __construct(bool $isCaptcha = false, ?KinopoiskUserMovieList $userMoviesDto = null)
    {
        $this->userMoviesPage = new UserMoviesPage($isCaptcha, $userMoviesDto);
    }

    public function parseUserMoviesPage(string $html): UserMoviesPage
    {
        return $this->userMoviesPage;
    }
}