<?php

declare(strict_types=1);

namespace Areyounormis\Kinopoisk;

use Areyounormis\UserMovie\UserMovieRateFactory;
use Areyounormis\UserMovie\UserMovieRates;
use Kinopoisk\KinopoiskUserMovieServiceInterface;

class UserMovieRateRepository
{
    protected KinopoiskUserMovieServiceInterface $kinopoiskUserMovieService;

    public function __construct(KinopoiskUserMovieServiceInterface $userMoviesCollector)
    {
        $this->kinopoiskUserMovieService = $userMoviesCollector;
    }

    public function getUserMovieRatesByUserId(int $userId): UserMovieRates
    {
        $userMoviesDto = $this->kinopoiskUserMovieService->getUserMoviesById($userId);

        return UserMovieRateFactory::makeCollectionFromKinopoiskUserMovies($userMoviesDto);
    }
}