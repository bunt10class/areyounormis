<?php

declare(strict_types=1);

namespace Tests\Unit\Areyounormis\Service\Coefficient;

use Areyounormis\Service\Coefficient\CoefficientService;
use Areyounormis\Service\Coefficient\Exceptions\InvalidCoefficientConfigException;
use Areyounormis\Service\Coefficient\Exceptions\InvalidCoefficientTypeException;
use Areyounormis\Service\Coefficient\Exceptions\InvalidCoefficientValueException;
use PHPUnit\Framework\TestCase;
use Tests\Unit\Areyounormis\Factories\ConfigDataFactory;
use Tests\Unit\Areyounormis\Factories\VoteFactory;
use Tests\Unit\Areyounormis\Mocks\CoefficientCalculatorMock;
use Tests\Unit\Areyounormis\Mocks\CoefficientConfigRepositoryMock;
use Tests\Unit\Areyounormis\Mocks\CoefficientValidatorMock;

class CoefficientServiceTest extends TestCase
{
    /**
     * @group unit
     * @group areyounormis
     * @group coefficient
     * @group coefficient_service
     */
    public function testGetCoefficientWithInvalidArgumentConfigException(): void
    {
        self::expectException(InvalidCoefficientConfigException::class);

        $classUnderTest = new CoefficientService(
            new CoefficientCalculatorMock(),
            new CoefficientConfigRepositoryMock([], true),
            new CoefficientValidatorMock(),
        );

        $classUnderTest->collectCoefficientValue('some_type', 0.5);
    }

    /**
     * @group unit
     * @group areyounormis
     * @group coefficient
     * @group coefficient_service
     */
    public function testGetCoefficientWithInvalidCoefficientTypeException(): void
    {
        self::expectException(InvalidCoefficientTypeException::class);

        $classUnderTest = new CoefficientService(
            new CoefficientCalculatorMock(),
            new CoefficientConfigRepositoryMock(),
            new CoefficientValidatorMock(true),
        );

        $classUnderTest->collectCoefficientValue('some_type', 0.5);
    }

    /**
     * @group unit
     * @group areyounormis
     * @group coefficient
     * @group coefficient_service
     */
    public function testGetCoefficientWithInvalidArgumentException(): void
    {
        self::expectException(InvalidCoefficientConfigException::class);

        $classUnderTest = new CoefficientService(
            new CoefficientCalculatorMock(),
            new CoefficientConfigRepositoryMock(),
            new CoefficientValidatorMock(false, true),
        );

        $classUnderTest->collectCoefficientValue('some_type', 0.5);
    }

    /**
     * @group unit
     * @group areyounormis
     * @group coefficient
     * @group coefficient_service
     */
    public function testGetCoefficientWithValueMoreThanAnyUpperLimit(): void
    {
        self::expectException(InvalidCoefficientValueException::class);

        $classUnderTest = $this->getDefaultClassUnderTest();

        $classUnderTest->collectCoefficientValue('some_type', 1.1);
    }

    /**
     * @group unit
     * @group areyounormis
     * @group coefficient
     * @group coefficient_service
     */
    public function testGetCoefficient(): void
    {
        $level = [
            'upper_limit' => 1,
            'color' => $levelColor = 'some_color',
            'description' => $levelDescription = 'some_level_description',
        ];
        $configData = ConfigDataFactory::getCoefficientConfigData(
            [$level],
            $name = 'some_name',
            $description = 'some_description',
        );
        $classUnderTest = new CoefficientService(
            new CoefficientCalculatorMock(),
            new CoefficientConfigRepositoryMock($configData),
            new CoefficientValidatorMock(),
        );

        $result = $classUnderTest->collectCoefficientValue($type = 'some_type', $value = 0.5);

        self::assertEquals($type, $result->getCoefficient()->getType());
        self::assertEquals($value, $result->getValue());
        self::assertEquals($name, $result->getCoefficient()->getName());
        self::assertEquals($description, $result->getCoefficient()->getDescription());
        self::assertEquals($levelColor, $result->getLevel()->getColor());
        self::assertEquals($levelDescription, $result->getLevel()->getDescription());
    }

    /**
     * @group unit
     * @group areyounormis
     * @group coefficient
     * @group coefficient_service
     */
    public function testGetCoefficientWithRightValuePrecision(): void
    {
        $classUnderTest = $this->getDefaultClassUnderTest();

        $result = $classUnderTest->collectCoefficientValue('some_type', 0.5001);

        self::assertEquals(0.5, $result->getValue());
    }

    /**
     * @group unit
     * @group areyounormis
     * @group coefficient
     * @group coefficient_service
     */
    public function testGetCoefficientWithSomeLevels(): void
    {
        $level1 = [
            'upper_limit' => 0.3,
            'color' => 'color1',
            'description' => 'description1',
        ];
        $level2 = [
            'upper_limit' => 0.6,
            'color' => $levelColor = 'color2',
            'description' => $levelDescription = 'description2',
        ];
        $level3 = [
            'upper_limit' => 1,
            'color' => 'color3',
            'description' => 'description3',
        ];
        $levels = [$level1, $level2, $level3];
        $configData = ConfigDataFactory::getCoefficientConfigData($levels, 'some_name', 'some_description');
        $classUnderTest = new CoefficientService(
            new CoefficientCalculatorMock(),
            new CoefficientConfigRepositoryMock($configData),
            new CoefficientValidatorMock(),
        );

        $result = $classUnderTest->collectCoefficientValue('some_type', 0.5);

        self::assertEquals($levelColor, $result->getLevel()->getColor());
        self::assertEquals($levelDescription, $result->getLevel()->getDescription());
    }

    /**
     * @group unit
     * @group areyounormis
     * @group coefficient
     * @group coefficient_service
     */
    public function testCalculateCoefficientByVotes(): void
    {
        $classUnderTest = new CoefficientService(
            new CoefficientCalculatorMock($value = 0.5),
            new CoefficientConfigRepositoryMock(ConfigDataFactory::getDefaultCoefficientConfigData()),
            new CoefficientValidatorMock(),
        );

        $result = $classUnderTest->calculateCoefficientValueByVotes('some_type', VoteFactory::getEmptyList());

        self::assertEquals($value, $result->getValue());
    }

    protected function getDefaultClassUnderTest(): CoefficientService
    {
        return new CoefficientService(
            new CoefficientCalculatorMock(),
            new CoefficientConfigRepositoryMock(ConfigDataFactory::getDefaultCoefficientConfigData()),
            new CoefficientValidatorMock(),
        );
    }
}
