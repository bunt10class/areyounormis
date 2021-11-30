<?php

declare(strict_types=1);

namespace Areyounormis\UserMovie;

use Areyounormis\UserRate\Exceptions\UserRateException;
use Areyounormis\UserRate\UserRateFactory;
use Kinopoisk\KinopoiskUserMovie;
use Kinopoisk\KinopoiskUserMovies;

class UserMovieRateFactory
{
    public static function makeCollectionFromKinopoiskUserMovies(KinopoiskUserMovies $kinopoiskUserMovies): UserMovieRates
    {
        $userMovieRates = new UserMovieRates();

        foreach ($kinopoiskUserMovies->getUserMovies() as $userMovieDto) {
            $userMovieRate = self::makeFromKinopoiskUserMovie($userMovieDto);
            if (is_null($userMovieRate)) {
                continue;
            }

            $userMovieRates->addOne($userMovieRate);
        }

        return $userMovieRates;
    }

    public static function makeFromKinopoiskUserMovie(KinopoiskUserMovie $kinopoiskUserMovie): ?UserMovieRate
    {
        $kpVote = $kinopoiskUserMovie->getKpVote();
        $userVote = $kinopoiskUserMovie->getUserVote();
        if (!is_numeric($kpVote) || !is_numeric($userVote)) {
            return null;
        }

        try {
            $userRate = UserRateFactory::makeKinopoiskUserRate($kpVote, $userVote);
        } catch (UserRateException $exception) {
            //todo log
            return null;
        }

        $movie = new Movie(
            $kinopoiskUserMovie->getRuName(),
            $kinopoiskUserMovie->getEnName(),
            $kinopoiskUserMovie->getLink(),
        );

        return new UserMovieRate($userRate, $movie);
    }
}