<?php

declare(strict_types=1);

namespace Areyounormis\UserMovie;


use Areyounormis\Exceptions\RelativeRateException;

/**
 * Сущность относительной оценки.
 * Описание: оценка (фильма) от -1 до 1 относительно средней оценки (по данному фильму)
 * -1 оценено максимально ниже относительно средней оценки
 * 0 оценка идентична средней
 * 1 оценено максимально выше относительно средней оценки
 */
class RelativeRate
{
    public const MAX_VALUE = 1;
    public const AVG_VALUE = 0;
    public const MIN_VALUE = -1;

    public const PRECISION = 3;

    private float $value;

    /**
     * @throws RelativeRateException
     */
    public function __construct(float $value)
    {
        $this->setValue($value);
    }

    public function getValue(): float
    {
        return $this->value;
    }

    /**
     * @throws RelativeRateException
     */
    protected function setValue(float $value): void
    {
        if ($value < self::MIN_VALUE || $value > self::MAX_VALUE) {
            throw new RelativeRateException();
        }
        $this->value = round($value, self::PRECISION);
    }

    public function __toString(): string
    {
        return (string)$this->value;
    }
}