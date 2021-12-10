<?php

declare(strict_types=1);

namespace Areyounormis\Coefficient;

class CoefficientValues
{
    /** @var CoefficientValue[] */
    private array $values = [];

    public function addItem(CoefficientValue $value): void
    {
        $this->values[] = $value;
    }

    public function getItems(): array
    {
        return $this->values;
    }
}