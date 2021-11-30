<?php

declare(strict_types=1);

namespace Areyounormis\UserMovie;

class RelativeRates
{
    /** @var RelativeRate[] */
    private array $relativeRates = [];

    public function addOne(RelativeRate $relativeRate): void
    {
        $this->relativeRates[] = $relativeRate;
    }

    public function getRelativeRates(): array
    {
        return $this->relativeRates;
    }
}