<?php

declare(strict_types=1);

namespace Tests\Unit\Areyounormis\Coefficient;

use Areyounormis\Coefficient\CoefficientHelper;
use Areyounormis\Coefficient\Exceptions\InvalidCoefficientTypeException;
use PHPUnit\Framework\TestCase;

class CoefficientHelperTest extends TestCase
{
    /**
     * @group unit
     * @group areyounormis
     * @group coefficient
     * @group coefficient_helper
     */
    public function testValidateTypeWithExistentType(): void
    {
        CoefficientHelper::validateType('norm');

        self::assertTrue(true);
    }

    /**
     * @group unit
     * @group areyounormis
     * @group coefficient
     * @group coefficient_helper
     */
    public function testValidateTypeWithNotExistentType(): void
    {
        self::expectException(InvalidCoefficientTypeException::class);

        CoefficientHelper::validateType('not_existent_type');
    }
}
