<?php

declare(strict_types=1);

namespace Tests\Unit\Kinopoisk\Mocks;

use Kinopoisk\UserMoviesDto;
use Kinopoisk\WebService\UserMoviesPageParser\UserMoviesPage;
use Kinopoisk\WebService\UserMoviesPageParser\UserMoviesParser;

class UserMoviesParserMock extends UserMoviesParser
{
    protected UserMoviesPage $userMoviesPage;

    public function __construct(bool $isCaptcha = false, ?UserMoviesDto $userMoviesDto = null)
    {
        $this->userMoviesPage = new UserMoviesPage($isCaptcha, $userMoviesDto);
    }

    public function parseUserMoviesPage(string $html): UserMoviesPage
    {
        return $this->userMoviesPage;
    }
}