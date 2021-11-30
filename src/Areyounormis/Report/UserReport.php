<?php

declare(strict_types=1);

namespace Areyounormis\Report;

use Areyounormis\UserMovie\User;
use Areyounormis\UserMovie\UserMovieRates;

class UserReport
{
    private User $user;

    private float $normCoefficient;
    private float $overUnderRateCoefficient;

    private UserMovieRates $overRateMovies;
    private UserMovieRates $normRateMovies;
    private UserMovieRates $underRateMovies;

    public function __construct(
        User $user,
        float $normCoefficient,
        float $overUnderRateCoefficient,
        UserMovieRates $overRateMovies,
        UserMovieRates $normRateMovies,
        UserMovieRates $underRateMovies,
    ) {
        $this->user = $user;
        $this->normCoefficient = $normCoefficient;
        $this->overUnderRateCoefficient = $overUnderRateCoefficient;
        $this->overRateMovies = $overRateMovies;
        $this->normRateMovies = $normRateMovies;
        $this->underRateMovies = $underRateMovies;
    }

    public function getUser(): User
    {
        return $this->user;
    }

    public function getNormCoefficient(): float
    {
        return $this->normCoefficient;
    }

    public function getOverUnderRateCoefficient(): float
    {
        return $this->overUnderRateCoefficient;
    }

    public function getOverRateMovies(): UserMovieRates
    {
        return $this->overRateMovies;
    }

    public function getNormRateMovies(): UserMovieRates
    {
        return $this->normRateMovies;
    }

    public function getUnderRateMovies(): UserMovieRates
    {
        return $this->underRateMovies;
    }
}