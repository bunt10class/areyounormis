<?php

declare(strict_types=1);

namespace Tests\Unit\Areyounormis\Infrastructure\Coefficient;

use Areyounormis\Infrastructure\Coefficient\Exceptions\InvalidCoefficientConfigException;
use Areyounormis\Infrastructure\Coefficient\Exceptions\InvalidCoefficientTypeException;
use Areyounormis\Infrastructure\Coefficient\CoefficientConfigRepository;
use PHPUnit\Framework\TestCase;
use Tests\Unit\Areyounormis\Factories\ConfigDataFactory;
use Tests\Unit\Areyounormis\Mocks\ConfigMock;

class CoefficientConfigRepositoryTest extends TestCase
{
    /**
     * @group unit
     * @group areyounormis
     * @group coefficient
     * @group coefficient_config_repository
     */
    public function testGetByTypeWithNotExistentType(): void
    {
        self::expectException(InvalidCoefficientTypeException::class);

        $configData = ConfigDataFactory::getDefaultCoefficientConfigData();
        $classUnderTest = new CoefficientConfigRepository(new ConfigMock($configData));

        $classUnderTest->getByType('not_existent_type');
    }

    /**
     * @group unit
     * @group areyounormis
     * @group coefficient
     * @group coefficient_config_repository
     */
    public function testGetByTypeWithInvalidArgumentConfigException(): void
    {
        self::expectException(InvalidCoefficientConfigException::class);

        $configData = ConfigDataFactory::getDefaultCoefficientConfigData();
        $classUnderTest = new CoefficientConfigRepository(new ConfigMock($configData, true));

        $classUnderTest->getByType('norm');
    }

    /**
     * @group unit
     * @group areyounormis
     * @group coefficient
     * @group coefficient_config_repository
     */
    public function testGetByType(): void
    {
        $level = [
            'upper_limit' => $levelUpperLimit = 1,
            'color' => $levelColor = 'some_color',
            'description' => $levelDescription = 'some_level_description',
        ];
        $configData = ConfigDataFactory::getCoefficientConfigData(
            [$level],
            $name = 'some_name',
            $description = 'some_description',
        );
        $classUnderTest = new CoefficientConfigRepository(new ConfigMock($configData));

        $result = $classUnderTest->getByType($type = 'norm');

        self::assertEquals($name, $result['name']);
        self::assertEquals($description, $result['description']);
        self::assertEquals($levelUpperLimit, $result['levels'][0]['upper_limit']);
        self::assertEquals($levelColor, $result['levels'][0]['color']);
        self::assertEquals($levelDescription, $result['levels'][0]['description']);
    }

    /**
     * @group unit
     * @group areyounormis
     * @group coefficient
     * @group coefficient_config_repository
     */
    public function testGetByTypeWithSomeLevels(): void
    {
        $level1 = [
            'upper_limit' => 0.3,
            'color' => 'color1',
            'description' => 'description1',
        ];
        $level2 = [
            'upper_limit' => 0.6,
            'color' => 'color2',
            'description' => 'description2',
        ];
        $level3 = [
            'upper_limit' => 1,
            'color' => 'color3',
            'description' => 'description3',
        ];
        $levels = [$level1, $level2, $level3];
        $configData = ConfigDataFactory::getCoefficientConfigData($levels, 'some_name', 'some_description');
        $classUnderTest = new CoefficientConfigRepository(new ConfigMock($configData));

        $result = $classUnderTest->getByType('norm');

        self::assertCount(3, $result['levels']);
    }
}
