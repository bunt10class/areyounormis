<?php

declare(strict_types=1);

namespace Areyounormis\UserMovie;

use Areyounormis\Exceptions\RelativeRateException;
use Kinopoisk\UserMovieDto;
use Kinopoisk\UserMoviesDto;
use Kinopoisk\VoteHelper;

class UserMovieRateFactory
{
    /**
     * @throws RelativeRateException
     */
    public static function makeCollectionFromKinopoiskDtoCollection(UserMoviesDto $userMoviesDto): UserMovieRates
    {
        $userMovieRates = new UserMovieRates();

        foreach ($userMoviesDto->getUserMovies() as $userMovieDto) {
            $userMovieRate = self::makeFromKinopoiskDto($userMovieDto);
            if (is_null($userMovieRate)) {
                continue;
            }

            $userMovieRates->addOne($userMovieRate);
        }

        return $userMovieRates;
    }

    /**
     * @throws RelativeRateException
     */
    public static function makeFromKinopoiskDto(UserMovieDto $userMovieDto): ?UserMovieRate
    {
        $kpVote = $userMovieDto->getKpVote();
        $userVote = $userMovieDto->getUserVote();
        if (!VoteHelper::isValidVote($kpVote) || !VoteHelper::isValidVote($userVote)) {
            return null;
        }

        $movie = new Movie(
            $userMovieDto->getRuName(),
            $userMovieDto->getEnName(),
            $userMovieDto->getLink(),
            (string)$kpVote,
        );

        $relativeRate = ($userVote - $kpVote) / VoteHelper::MAX_VOTES_DIFF;

        return new UserMovieRate(
            (string)$userVote,
            new RelativeRate($relativeRate),
            $movie
        );
    }
}