<?php

declare(strict_types=1);

namespace Areyounormis\UserRate;

use Areyounormis\UserRate\Exceptions\UserRateBoundariesException;
use Areyounormis\UserRate\Exceptions\UserRateVoteException;

/**
 * float $maxVote - верхняя граница оценки (-inf : inf)
 * float $minVote - нижняя граница оценки (-inf : $maxVote)
 * float $avgVote - средняя оценка [$minVote : $maxVote]
 * float $userVote - оценка пользователя [$minVote : $maxVote]
 *
 * float $maxDiff - максимально возможная разница в оценках (0 : inf)
 * float $absoluteDiff - абсолютная разница в оценках [-$maxDiff : $maxDiff]
 * float $relativeDiff - относительная разница в оценках [-1 : 1]
 * float $moduleRelativeDiff - относительная разница в оценках по модулю [0 : 1]
 */
class UserRate
{
    private float $maxVote;
    private float $minVote;
    private float $avgVote;
    private float $userVote;
    private float $maxDiff;
    private float $absoluteDiff;
    private float $relativeDiff;
    private float $moduleRelativeDiff;

    /**
     * @throws UserRateBoundariesException
     * @throws UserRateVoteException
     */
    public function __construct(float $maxVote, float $minVote, float $avgVote, float $userVote)
    {
        $this->validateArguments($maxVote, $minVote, $avgVote, $userVote);

        $this->maxVote = $maxVote;
        $this->minVote = $minVote;
        $this->avgVote = $avgVote;
        $this->userVote = $userVote;

        $this->setMaxDiff();
        $this->setAbsoluteDiff();
        $this->setRelativeDiff();
        $this->setModuleRelativeDiff();
    }

    /**
     * @throws UserRateBoundariesException
     * @throws UserRateVoteException
     */
    private function validateArguments(float $maxVote, float $minVote, float $avgVote, float $userVote): void
    {
        if ($maxVote < 0 || $minVote < 0 || $maxVote <= $minVote) {
            throw new UserRateBoundariesException();
        }
        if ($avgVote < $minVote || $avgVote > $maxVote) {
            throw new UserRateVoteException();
        }
        if ($userVote < $minVote || $userVote > $maxVote) {
            throw new UserRateVoteException();
        }
    }

    private function setMaxDiff(): void
    {
        $this->maxDiff = $this->maxVote - $this->minVote;
    }

    private function setAbsoluteDiff(): void
    {
        $this->absoluteDiff = $this->userVote - $this->avgVote;
    }

    private function setRelativeDiff(): void
    {
        $this->relativeDiff = $this->absoluteDiff / $this->maxDiff;
    }

    private function setModuleRelativeDiff(): void
    {
        $this->moduleRelativeDiff = abs($this->relativeDiff);
    }

    public function getMaxVote(): float
    {
        return $this->maxVote;
    }

    public function getMinVote(): float
    {
        return $this->minVote;
    }

    public function getAvgVote(): float
    {
        return $this->avgVote;
    }

    public function getUserVote(): float
    {
        return $this->userVote;
    }

    public function getMaxDiff(): float
    {
        return $this->maxDiff;
    }

    public function getAbsoluteDiff(): float
    {
        return $this->absoluteDiff;
    }

    public function getRelativeDiff(): float
    {
        return $this->relativeDiff;
    }

    public function getModuleRelativeDiff(): float
    {
        return $this->moduleRelativeDiff;
    }
}