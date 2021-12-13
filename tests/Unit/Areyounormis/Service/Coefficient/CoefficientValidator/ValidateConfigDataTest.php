<?php

declare(strict_types=1);

namespace Tests\Unit\Areyounormis\Service\Coefficient\CoefficientValidator;

use Tests\Unit\Areyounormis\Factories\ConfigDataFactory;
use Webmozart\Assert\InvalidArgumentException;

class ValidateConfigDataTest extends CoefficientValidatorMain
{
    /**
     * @group unit
     * @group areyounormis
     * @group coefficient
     * @group coefficient_validator
     */
    public function testValidConfigData(): void
    {
        $configData = ConfigDataFactory::getDefaultCoefficientConfigData();

        $this->classUnderTest->validateConfigData($configData);

        self::assertTrue(true);
    }

    /**
     * @group unit
     * @group areyounormis
     * @group coefficient
     * @group coefficient_validator
     */
    public function testConfigDataWithoutName(): void
    {
        self::expectException(InvalidArgumentException::class);

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

        $this->classUnderTest->validateConfigData($configData);
    }

    /**
     * @group unit
     * @group areyounormis
     * @group coefficient
     * @group coefficient_validator
     */
    public function testConfigDataWithNameNotString(): void
    {
        self::expectException(InvalidArgumentException::class);

        $level = [
            'upper_limit' => 1,
            'color' => 'some_color',
            'description' => 'some_description',
        ];
        $configData = ConfigDataFactory::getCoefficientConfigData([$level], 123, 'some_description');

        $this->classUnderTest->validateConfigData($configData);
    }

    /**
     * @group unit
     * @group areyounormis
     * @group coefficient
     * @group coefficient_validator
     */
    public function testConfigDataWithoutDescription(): void
    {
        self::expectException(InvalidArgumentException::class);

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

        $this->classUnderTest->validateConfigData($configData);
    }

    /**
     * @group unit
     * @group areyounormis
     * @group coefficient
     * @group coefficient_validator
     */
    public function testConfigDataWithDescriptionNotString(): void
    {
        self::expectException(InvalidArgumentException::class);

        $level = [
            'upper_limit' => 1,
            'color' => 'some_color',
            'description' => 'some_description',
        ];
        $configData = ConfigDataFactory::getCoefficientConfigData([$level], 'some_name', 123);

        $this->classUnderTest->validateConfigData($configData);
    }

    /**
     * @group unit
     * @group areyounormis
     * @group coefficient
     * @group coefficient_validator
     */
    public function testConfigDataWithoutLevels(): void
    {
        self::expectException(InvalidArgumentException::class);

        $configData = [
            'name' => 'some_name',
            'description' => 'some_description',
        ];

        $this->classUnderTest->validateConfigData($configData);
    }

    /**
     * @group unit
     * @group areyounormis
     * @group coefficient
     * @group coefficient_validator
     */
    public function testConfigDataWithLevelsNotArray(): void
    {
        self::expectException(InvalidArgumentException::class);

        $configData = [
            'levels' => 'not_array',
            'name' => 'some_name',
            'description' => 'some_description',
        ];

        $this->classUnderTest->validateConfigData($configData);
    }

    /**
     * @group unit
     * @group areyounormis
     * @group coefficient
     * @group coefficient_validator
     */
    public function testConfigDataWithoutAnyLevel(): void
    {
        self::expectException(InvalidArgumentException::class);

        $configData = ConfigDataFactory::getCoefficientConfigData([], 'some_name', 'some_description');

        $this->classUnderTest->validateConfigData($configData);
    }

    /**
     * @group unit
     * @group areyounormis
     * @group coefficient
     * @group coefficient_validator
     */
    public function testConfigDataWithLevelWithoutUpperLimit(): void
    {
        self::expectException(InvalidArgumentException::class);

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

        $this->classUnderTest->validateConfigData($configData);
    }

    /**
     * @group unit
     * @group areyounormis
     * @group coefficient
     * @group coefficient_validator
     */
    public function testConfigDataWithLevelWithUpperLimitStringNotNumeric(): void
    {
        self::expectException(InvalidArgumentException::class);

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

        $this->classUnderTest->validateConfigData($configData);
    }

    /**
     * @group unit
     * @group areyounormis
     * @group coefficient
     * @group coefficient_validator
     */
    public function testConfigDataWithLevelWithUpperLimitBool(): void
    {
        self::expectException(InvalidArgumentException::class);

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

        $this->classUnderTest->validateConfigData($configData);
    }

    /**
     * @group unit
     * @group areyounormis
     * @group coefficient
     * @group coefficient_validator
     */
    public function testConfigDataWithLevelWithUpperLimitEmptyArray(): void
    {
        self::expectException(InvalidArgumentException::class);

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

        $this->classUnderTest->validateConfigData($configData);
    }

    /**
     * @group unit
     * @group areyounormis
     * @group coefficient
     * @group coefficient_validator
     */
    public function testConfigDataWithLevelWithoutColor(): void
    {
        self::expectException(InvalidArgumentException::class);

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

        $this->classUnderTest->validateConfigData($configData);
    }

    /**
     * @group unit
     * @group areyounormis
     * @group coefficient
     * @group coefficient_validator
     */
    public function testConfigDataWithLevelWithColorNotString(): void
    {
        self::expectException(InvalidArgumentException::class);


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

        $this->classUnderTest->validateConfigData($configData);
    }

    /**
     * @group unit
     * @group areyounormis
     * @group coefficient
     * @group coefficient_validator
     */
    public function testConfigDataWithLevelWithoutDescription(): void
    {
        self::expectException(InvalidArgumentException::class);

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

        $this->classUnderTest->validateConfigData($configData);
    }

    /**
     * @group unit
     * @group areyounormis
     * @group coefficient
     * @group coefficient_validator
     */
    public function testConfigDataWithLevelWithDescriptionNotString(): void
    {
        self::expectException(InvalidArgumentException::class);

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

        $this->classUnderTest->validateConfigData($configData);
    }
}
