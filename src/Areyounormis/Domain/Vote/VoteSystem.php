<?php

declare(strict_types=1);

namespace Areyounormis\Domain\Vote;

/**
 * float $max - верхняя граница оценки (-inf : inf)
 * float $min - нижняя граница оценки (-inf : $max)
 * float $diff - разница в оценках (0 : inf)
 * float $step - шаг оценки (0 : $max)
 * float $relativeStep - относительный шаг оценки (0 : 1)
 */
class VoteSystem
{
    public const PRECISION = 3;

    private float $max;
    private float $min;
    private float $diff;
    private float $step;
    private float $relativeStep;

    public function __construct(float $max, float $min, float $maxDiff, float $step, float $relativeStep)
    {
        $this->max = $max;
        $this->min = $min;
        $this->diff = $maxDiff;
        $this->step = $step;
        $this->relativeStep = $relativeStep;
    }

    public function getMax(): float
    {
        return $this->max;
    }

    public function getMin(): float
    {
        return $this->min;
    }

    public function getDiff(): float
    {
        return $this->diff;
    }

    public function getStep(): float
    {
        return $this->step;
    }

    public function getRelativeStep(): float
    {
        return $this->relativeStep;
    }

    public function toArray(): array
    {
        return [
            'max' => $this->getMax(),
            'min' => $this->getMin(),
            'diff' => $this->getDiff(),
            'step' => $this->getStep(),
            'relative_step' => $this->getRelativeStep(),
        ];
    }
}