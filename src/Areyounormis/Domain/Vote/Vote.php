<?php

declare(strict_types=1);

namespace Areyounormis\Domain\Vote;

/**
 * float $userVote - оценка пользователя
 * float $resourceVote - оценка на ресурсе
 * float $absoluteDiff - абсолютная разница в оценках
 * float $relativeDiff - относительная разница в оценках [-1 : 1]
 * float $moduleRelativeDiff - относительная разница в оценках по модулю [0 : 1]
 */
class Vote
{
    private float $userVote;
    private float $resourceVote;
    private float $absoluteDiff;
    private float $relativeDiff;
    private float $moduleRelativeDiff;

    public function __construct(
        float $userVote,
        float $resourceVote,
        float $absoluteDiff,
        float $relativeDiff,
        float $moduleRelativeDiff
    ) {
        $this->userVote = $userVote;
        $this->resourceVote = $resourceVote;
        $this->absoluteDiff = $absoluteDiff;
        $this->relativeDiff = $relativeDiff;
        $this->moduleRelativeDiff = $moduleRelativeDiff;
    }

    public function getUserVote(): float
    {
        return $this->userVote;
    }

    public function getResourceVote(): float
    {
        return $this->resourceVote;
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