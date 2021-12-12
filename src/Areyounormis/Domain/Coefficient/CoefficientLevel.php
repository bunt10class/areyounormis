<?php

declare(strict_types=1);

namespace Areyounormis\Domain\Coefficient;

class CoefficientLevel
{
    private const DEFAULT_LEVEL_COLOR = 'grey';

    protected string $color;
    protected string $description;

    public function __construct(
        string $color = self::DEFAULT_LEVEL_COLOR,
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