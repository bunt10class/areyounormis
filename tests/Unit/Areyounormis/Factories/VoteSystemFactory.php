<?php

declare(strict_types=1);

namespace Tests\Unit\Areyounormis\Factories;

use Areyounormis\Domain\Vote\VoteSystem;

class VoteSystemFactory
{
    /**
     * максимальная оценка - 10
     * минимальная оценка - 0
     * шаг - 1
     */
    public static function getDefault(): VoteSystem
    {
        return new VoteSystem(10, 0, 10, 1, 0.1);
    }
}