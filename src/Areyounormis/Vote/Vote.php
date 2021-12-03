<?php

declare(strict_types=1);

namespace Areyounormis\Vote;

/**
 * float $userVote - оценка пользователя
 * float $siteVote - оценка сайта
 * float $absoluteDiff - абсолютная разница в оценках
 * float $relativeDiff - относительная разница в оценках [-1 : 1]
 * float $moduleRelativeDiff - относительная разница в оценках по модулю [0 : 1]
 */
class Vote
{
    private float $userVote;
    private float $siteVote;
    private float $absoluteDiff;
    private float $relativeDiff;
    private float $moduleRelativeDiff;

    public function __construct(
        float $userVote,
        float $siteVote,
        float $absoluteDiff,
        float $relativeDiff,
        float $moduleRelativeDiff
    ) {
        $this->userVote = $userVote;
        $this->siteVote = $siteVote;
        $this->absoluteDiff = $absoluteDiff;
        $this->relativeDiff = $relativeDiff;
        $this->moduleRelativeDiff = $moduleRelativeDiff;
    }

    public function getUserVote(): float
    {
        return $this->userVote;
    }

    public function getSiteVote(): float
    {
        return $this->siteVote;
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