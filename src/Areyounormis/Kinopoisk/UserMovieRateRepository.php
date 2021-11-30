<?php

declare(strict_types=1);

namespace Areyounormis\Kinopoisk;

use Areyounormis\Exceptions\RelativeRateException;
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

    /**
     * @throws RelativeRateException
     */
    public function getUserMovieRatesByUserId(int $userId): UserMovieRates
    {
        $userMoviesDto = $this->kinopoiskUserMovieService->getUserMoviesById($userId);

        return UserMovieRateFactory::makeCollectionFromKinopoiskDtoCollection($userMoviesDto);
    }
}