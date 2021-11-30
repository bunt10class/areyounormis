<?php

declare(strict_types=1);

namespace Areyounormis\UserRate;

class UserRates
{
    /** @var UserRate[] */
    private array $userRates = [];

    public function addOne(UserRate $userRate): void
    {
        $this->userRates[] = $userRate;
    }

    public function getUserRates(): array
    {
        return $this->userRates;
    }

    public function getCount(): int
    {
        return count($this->userRates);
    }
}