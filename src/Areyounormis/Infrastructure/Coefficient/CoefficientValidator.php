<?php

declare(strict_types=1);

namespace Areyounormis\Infrastructure\Coefficient;

use Areyounormis\Infrastructure\Coefficient\Exceptions\InvalidCoefficientTypeException;
use Areyounormis\Domain\Coefficient\CoefficientHelper;
use Webmozart\Assert\Assert;
use Webmozart\Assert\InvalidArgumentException;

class CoefficientValidator
{
    /**
     * @throws InvalidCoefficientTypeException
     */
    public static function validateType(string $type): void
    {
        if (!in_array($type, CoefficientHelper::TYPES)) {
            throw new InvalidCoefficientTypeException($type);
        }
    }

    /**
     * @throws InvalidArgumentException
     */
    public static function validateConfigData(mixed $coefficient): void
    {
        Assert::isArray($coefficient);

        Assert::keyExists($coefficient, 'levels');
        Assert::isArray($coefficient['levels']);
        Assert::isNonEmptyList($coefficient['levels']);

        foreach ($coefficient['levels'] as $level) {
            Assert::isArray($level);
            Assert::keyExists($level, 'upper_limit');
            Assert::numeric($level['upper_limit']);
            Assert::keyExists($level, 'color');
            Assert::string($level['color']);
            Assert::keyExists($level, 'description');
            Assert::string($level['description']);
        }

        Assert::keyExists($coefficient, 'name');
        Assert::string($coefficient['name']);

        Assert::keyExists($coefficient, 'description');
        Assert::string($coefficient['description']);
    }
}