<?php

declare(strict_types=1);

namespace Tests\Unit\Areyounormis\Service\Coefficient\CoefficientValidator;

use Areyounormis\Service\Coefficient\Exceptions\InvalidCoefficientTypeException;

class ValidateTypeTest extends CoefficientValidatorMain
{
    /**
     * @group unit
     * @group areyounormis
     * @group coefficient
     * @group coefficient_validator
     */
    public function testWithExistentType(): void
    {
        $this->classUnderTest->validateType('norm');

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

        $this->classUnderTest->validateType('not_existent_type');
    }
}
