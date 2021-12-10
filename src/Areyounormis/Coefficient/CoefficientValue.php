<?php

declare(strict_types=1);

namespace Areyounormis\Coefficient;

class CoefficientValue
{
    protected Coefficient $coefficient;
    protected float $value;
    protected CoefficientLevel $level;

    public function __construct(
        Coefficient $coefficient,
        float $value,
        CoefficientLevel $level,
    ) {
        $this->coefficient = $coefficient;
        $this->value = $value;
        $this->level = $level;
    }

    public function getCoefficient(): Coefficient
    {
        return $this->coefficient;
    }

    public function getValue(): float
    {
        return $this->value;
    }

    public function getLevel(): CoefficientLevel
    {
        return $this->level;
    }

    public function toArray(): array
    {
        return [
            'coefficient' => [
                'type' => $this->getCoefficient()->getType(),
                'name' => $this->getCoefficient()->getName(),
                'description' => $this->getCoefficient()->getDescription(),
            ],
            'value' => $this->getValue(),
            'level' => [
                'color' => $this->level->getColor(),
                'description' => $this->level->getDescription(),
            ],
        ];
    }
}