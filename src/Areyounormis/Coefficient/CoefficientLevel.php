<?php

declare(strict_types=1);

namespace Areyounormis\Coefficient;

class CoefficientLevel
{
    protected string $color;
    protected string $description;

    public function __construct(
        string $color = CoefficientHelper::DEFAULT_LEVEL_COLOR,
        string $description = '',
    ) {
        $this->color = $color;
        $this->description = $description;
    }

    public function getColor(): string
    {
        return $this->color;
    }

    public function getDescription(): string
    {
        return $this->description;
    }
}