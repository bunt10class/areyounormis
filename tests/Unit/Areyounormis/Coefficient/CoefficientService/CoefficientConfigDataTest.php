<?php

declare(strict_types=1);

namespace Tests\Unit\Areyounormis\Coefficient\CoefficientService;

use Areyounormis\Coefficient\CoefficientService;
use Areyounormis\Coefficient\Exceptions\InvalidCoefficientConfigException;
use PHPUnit\Framework\TestCase;
use Tests\Unit\Areyounormis\Mocks\CoefficientCalculatorMock;
use Tests\Unit\Areyounormis\Mocks\ConfigMock;

class CoefficientConfigDataTest extends TestCase
{
    /**
     * @group unit
     * @group areyounormis
     * @group coefficient
     * @group coefficient_service
     */
    public function testValidConfigData(): void
    {
        $configData = [
            'levels' => [
                [
                    'upper_limit' => 1,
                    'color' => 'some_color',
                    'description' => 'some_description',
                ],
            ],
            'name' => 'some_name',
            'description' => 'some_description',
        ];
        $classUnderTest = new CoefficientService(new CoefficientCalculatorMock(), new ConfigMock($configData));

        $classUnderTest->getCoefficientValue('norm', 0.5);

        self::assertTrue(true);
    }

    /**
     * @group unit
     * @group areyounormis
     * @group coefficient
     * @group coefficient_service
     */
    public function testConfigDataWithoutName(): void
    {
        self::expectException(InvalidCoefficientConfigException::class);

        $configData = [
            'levels' => [
                [
                    'upper_limit' => 1,
                    'color' => 'some_color',
                    'description' => 'some_description',
                ],
            ],
            'description' => 'some_description',
        ];
        $classUnderTest = new CoefficientService(new CoefficientCalculatorMock(), new ConfigMock($configData));

        $classUnderTest->getCoefficientValue('norm', 0.5);
    }

    /**
     * @group unit
     * @group areyounormis
     * @group coefficient
     * @group coefficient_service
     */
    public function testConfigDataWithNameNotString(): void
    {
        self::expectException(InvalidCoefficientConfigException::class);

        $configData = [
            'levels' => [
                [
                    'upper_limit' => 1,
                    'color' => 'some_color',
                    'description' => 'some_description',
                ],
            ],
            'name' => 123,
            'description' => 'some_description',
        ];
        $classUnderTest = new CoefficientService(new CoefficientCalculatorMock(), new ConfigMock($configData));

        $classUnderTest->getCoefficientValue('norm', 0.5);
    }

    /**
     * @group unit
     * @group areyounormis
     * @group coefficient
     * @group coefficient_service
     */
    public function testConfigDataWithoutDescription(): void
    {
        self::expectException(InvalidCoefficientConfigException::class);

        $configData = [
            'levels' => [
                [
                    'upper_limit' => 1,
                    'color' => 'some_color',
                    'description' => 'some_description',
                ],
            ],
            'name' => 'some_name',
        ];
        $classUnderTest = new CoefficientService(new CoefficientCalculatorMock(), new ConfigMock($configData));

        $classUnderTest->getCoefficientValue('norm', 0.5);
    }

    /**
     * @group unit
     * @group areyounormis
     * @group coefficient
     * @group coefficient_service
     */
    public function testConfigDataWithDescriptionNotString(): void
    {
        self::expectException(InvalidCoefficientConfigException::class);

        $configData = [
            'levels' => [
                [
                    'upper_limit' => 1,
                    'color' => 'some_color',
                    'description' => 'some_description',
                ],
            ],
            'name' => 'some_name',
            'description' => 123,
        ];
        $classUnderTest = new CoefficientService(new CoefficientCalculatorMock(), new ConfigMock($configData));

        $classUnderTest->getCoefficientValue('norm', 0.5);
    }

    /**
     * @group unit
     * @group areyounormis
     * @group coefficient
     * @group coefficient_service
     */
    public function testConfigDataWithoutLevels(): void
    {
        self::expectException(InvalidCoefficientConfigException::class);

        $configData = [
            'name' => 'some_name',
            'description' => 'some_description',
        ];
        $classUnderTest = new CoefficientService(new CoefficientCalculatorMock(), new ConfigMock($configData));

        $classUnderTest->getCoefficientValue('norm', 0.5);
    }

    /**
     * @group unit
     * @group areyounormis
     * @group coefficient
     * @group coefficient_service
     */
    public function testConfigDataWithLevelsNotArray(): void
    {
        self::expectException(InvalidCoefficientConfigException::class);

        $configData = [
            'levels' => 'not_array',
            'name' => 'some_name',
            'description' => 'some_description',
        ];
        $classUnderTest = new CoefficientService(new CoefficientCalculatorMock(), new ConfigMock($configData));

        $classUnderTest->getCoefficientValue('norm', 0.5);
    }

    /**
     * @group unit
     * @group areyounormis
     * @group coefficient
     * @group coefficient_service
     */
    public function testConfigDataWithoutAnyLevel(): void
    {
        self::expectException(InvalidCoefficientConfigException::class);

        $configData = [
            'levels' => [],
            'name' => 'some_name',
            'description' => 'some_description',
        ];
        $classUnderTest = new CoefficientService(new CoefficientCalculatorMock(), new ConfigMock($configData));

        $classUnderTest->getCoefficientValue('norm', 0.5);
    }

    /**
     * @group unit
     * @group areyounormis
     * @group coefficient
     * @group coefficient_service
     */
    public function testConfigDataWithLevelWithoutUpperLimit(): void
    {
        self::expectException(InvalidCoefficientConfigException::class);

        $configData = [
            'levels' => [
                [
                    'color' => 'some_color',
                    'description' => 'some_description',
                ],
            ],
            'name' => 'some_name',
            'description' => 'some_description',
        ];
        $classUnderTest = new CoefficientService(new CoefficientCalculatorMock(), new ConfigMock($configData));

        $classUnderTest->getCoefficientValue('norm', 0.5);
    }

    /**
     * @group unit
     * @group areyounormis
     * @group coefficient
     * @group coefficient_service
     */
    public function testConfigDataWithLevelWithUpperLimitStringNotNumeric(): void
    {
        self::expectException(InvalidCoefficientConfigException::class);

        $configData = [
            'levels' => [
                [
                    'upper_limit' => 'not_numeric',
                    'color' => 'some_color',
                    'description' => 'some_description',
                ],
            ],
            'name' => 'some_name',
            'description' => 'some_description',
        ];
        $classUnderTest = new CoefficientService(new CoefficientCalculatorMock(), new ConfigMock($configData));

        $classUnderTest->getCoefficientValue('norm', 0.5);
    }

    /**
     * @group unit
     * @group areyounormis
     * @group coefficient
     * @group coefficient_service
     */
    public function testConfigDataWithLevelWithUpperLimitBool(): void
    {
        self::expectException(InvalidCoefficientConfigException::class);

        $configData = [
            'levels' => [
                [
                    'upper_limit' => true,
                    'color' => 'some_color',
                    'description' => 'some_description',
                ],
            ],
            'name' => 'some_name',
            'description' => 'some_description',
        ];
        $classUnderTest = new CoefficientService(new CoefficientCalculatorMock(), new ConfigMock($configData));

        $classUnderTest->getCoefficientValue('norm', 0.5);
    }

    /**
     * @group unit
     * @group areyounormis
     * @group coefficient
     * @group coefficient_service
     */
    public function testConfigDataWithLevelWithUpperLimitEmptyArray(): void
    {
        self::expectException(InvalidCoefficientConfigException::class);

        $configData = [
            'levels' => [
                [
                    'upper_limit' => [],
                    'color' => 'some_color',
                    'description' => 'some_description',
                ],
            ],
            'name' => 'some_name',
            'description' => 'some_description',
        ];
        $classUnderTest = new CoefficientService(new CoefficientCalculatorMock(), new ConfigMock($configData));

        $classUnderTest->getCoefficientValue('norm', 0.5);
    }

    /**
     * @group unit
     * @group areyounormis
     * @group coefficient
     * @group coefficient_service
     */
    public function testConfigDataWithLevelWithoutColor(): void
    {
        self::expectException(InvalidCoefficientConfigException::class);

        $configData = [
            'levels' => [
                [
                    'upper_limit' => 1,
                    'description' => 'some_description',
                ],
            ],
            'name' => 'some_name',
            'description' => 'some_description',
        ];
        $classUnderTest = new CoefficientService(new CoefficientCalculatorMock(), new ConfigMock($configData));

        $classUnderTest->getCoefficientValue('norm', 0.5);
    }

    /**
     * @group unit
     * @group areyounormis
     * @group coefficient
     * @group coefficient_service
     */
    public function testConfigDataWithLevelWithColorNotString(): void
    {
        self::expectException(InvalidCoefficientConfigException::class);


        $configData = [
            'levels' => [
                [
                    'upper_limit' => 1,
                    'color' => 123,
                    'description' => 'some_description',
                ],
            ],
            'name' => 'some_name',
            'description' => 'some_description',
        ];
        $classUnderTest = new CoefficientService(new CoefficientCalculatorMock(), new ConfigMock($configData));

        $classUnderTest->getCoefficientValue('norm', 0.5);
    }

    /**
     * @group unit
     * @group areyounormis
     * @group coefficient
     * @group coefficient_service
     */
    public function testConfigDataWithLevelWithoutDescription(): void
    {
        self::expectException(InvalidCoefficientConfigException::class);

        $configData = [
            'levels' => [
                [
                    'upper_limit' => 1,
                    'color' => 'some_color',
                ],
            ],
            'name' => 'some_name',
            'description' => 'some_description',
        ];
        $classUnderTest = new CoefficientService(new CoefficientCalculatorMock(), new ConfigMock($configData));

        $classUnderTest->getCoefficientValue('norm', 0.5);
    }

    /**
     * @group unit
     * @group areyounormis
     * @group coefficient
     * @group coefficient_service
     */
    public function testConfigDataWithLevelWithDescriptionNotString(): void
    {
        self::expectException(InvalidCoefficientConfigException::class);

        $configData = [
            'levels' => [
                [
                    'upper_limit' => 1,
                    'color' => 'some_color',
                    'description' => 123,
                ],
            ],
            'name' => 'some_name',
            'description' => 'some_description',
        ];
        $classUnderTest = new CoefficientService(new CoefficientCalculatorMock(), new ConfigMock($configData));

        $classUnderTest->getCoefficientValue('norm', 0.5);
    }
}
