<?php

declare(strict_types=1);

namespace Areyounormis\Coefficient;

class Coefficients
{
    /** @var Coefficient[] */
    private array $coefficients = [];

    public function addItem(Coefficient $coefficient): void
    {
        $this->coefficients[] = $coefficient;
    }

    public function getItems(): array
    {
        return $this->coefficients;
    }
}