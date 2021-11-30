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

    private UserMovieRates $overRates;
    private UserMovieRates $normRates;
    private UserMovieRates $underRates;

    public function __construct(
        User $user,
        float $normCoefficient,
        float $overUnderRateCoefficient,
        UserMovieRates $overRates,
        UserMovieRates $normRates,
        UserMovieRates $underRates,
    ) {
        $this->user = $user;
        $this->normCoefficient = $normCoefficient;
        $this->overUnderRateCoefficient = $overUnderRateCoefficient;
        $this->overRates = $overRates;
        $this->normRates = $normRates;
        $this->underRates = $underRates;
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

    public function getOverRates(): UserMovieRates
    {
        return $this->overRates;
    }

    public function getNormRates(): UserMovieRates
    {
        return $this->normRates;
    }

    public function getUnderRates(): UserMovieRates
    {
        return $this->underRates;
    }
}