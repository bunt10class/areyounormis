<?php

declare(strict_types=1);

namespace Tests\Unit\Areyounormis\Infrastructure\Coefficient\CoefficientValidator;

use Areyounormis\Infrastructure\Coefficient\CoefficientValidator;
use Areyounormis\Infrastructure\Coefficient\Exceptions\InvalidCoefficientTypeException;
use PHPUnit\Framework\TestCase;

class ValidateTypeTest extends TestCase
{
    /**
     * @group unit
     * @group areyounormis
     * @group coefficient
     * @group coefficient_validator
     */
    public function testWithExistentType(): void
    {
        CoefficientValidator::validateType('norm');

        self::assertTrue(true);
    }

    /**
     * @group unit
     * @group areyounormis
     * @group coefficient
     * @group coefficient_validator
     */
    public function testWithNotExistentType(): void
    {
        self::expectException(InvalidCoefficientTypeException::class);

        CoefficientValidator::validateType('not_existent_type');
    }
}
