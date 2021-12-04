<?php

declare(strict_types=1);

namespace Tests\Unit\Areyounormis\Coefficient\CoefficientService;

use Areyounormis\Coefficient\CoefficientService;
use Areyounormis\Coefficient\Exceptions\InvalidCoefficientConfigException;
use Areyounormis\Coefficient\Exceptions\InvalidCoefficientTypeException;
use Areyounormis\Coefficient\Exceptions\InvalidCoefficientValueException;
use Areyounormis\Vote\Votes;
use PHPUnit\Framework\TestCase;
use Tests\Unit\Areyounormis\Factories\ConfigDataFactory;
use Tests\Unit\Areyounormis\Mocks\CoefficientCalculatorMock;
use Tests\Unit\Areyounormis\Mocks\ConfigMock;

class CoefficientServiceTest extends TestCase
{
    /**
     * @group unit
     * @group areyounormis
     * @group coefficient
     * @group coefficient_service
     */
    public function testGetCoefficientWithNotExistentType(): void
    {
        self::expectException(InvalidCoefficientTypeException::class);

        $classUnderTest = new CoefficientService(
            new CoefficientCalculatorMock(),
            new ConfigMock($this->getDefaultConfigData())
        );

        $classUnderTest->getCoefficient('not_existent_type', 0.5);
    }

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
            new ConfigMock($this->getDefaultConfigData(), true)
        );

        $classUnderTest->getCoefficient('norm', 0.5);
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

        $classUnderTest = new CoefficientService(
            new CoefficientCalculatorMock(),
            new ConfigMock($this->getDefaultConfigData())
        );

        $classUnderTest->getCoefficient('norm', 1.1);
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
        $configData = ConfigDataFactory::getCoefficientConfigData([$level], $description = 'some_description');
        $classUnderTest = new CoefficientService(new CoefficientCalculatorMock(), new ConfigMock($configData));

        $result = $classUnderTest->getCoefficient($type = 'norm', $value = 0.5);

        self::assertEquals($type, $result->getType());
        self::assertEquals($value, $result->getValue());
        self::assertEquals($description, $result->getDescription());
        self::assertEquals($levelColor, $result->getLevelColor());
        self::assertEquals($levelDescription, $result->getLevelDescription());
    }

    /**
     * @group unit
     * @group areyounormis
     * @group coefficient
     * @group coefficient_service
     */
    public function testGetCoefficientWithRightValuePrecision(): void
    {
        $classUnderTest = new CoefficientService(
            new CoefficientCalculatorMock(),
            new ConfigMock($this->getDefaultConfigData())
        );

        $result = $classUnderTest->getCoefficient('norm', 0.5001);

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
        $configData = ConfigDataFactory::getCoefficientConfigData($levels, 'some_description');
        $classUnderTest = new CoefficientService(new CoefficientCalculatorMock(), new ConfigMock($configData));

        $result = $classUnderTest->getCoefficient('norm', 0.5);

        self::assertEquals($levelColor, $result->getLevelColor());
        self::assertEquals($levelDescription, $result->getLevelDescription());
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
            new ConfigMock($this->getDefaultConfigData())
        );

        $result = $classUnderTest->calculateCoefficientByVotes('norm', new Votes());

        self::assertEquals($value, $result->getValue());
    }

    protected function getDefaultConfigData(): array
    {
        $level = [
            'upper_limit' => 1,
            'color' => 'some_color',
            'description' => 'some_level_description',
        ];
        return ConfigDataFactory::getCoefficientConfigData([$level], 'some_description');
    }
}
