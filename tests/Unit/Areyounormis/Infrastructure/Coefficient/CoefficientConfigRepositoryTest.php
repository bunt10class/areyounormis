<?php

declare(strict_types=1);

namespace Tests\Unit\Areyounormis\Infrastructure\Coefficient;

use Areyounormis\Infrastructure\Coefficient\CoefficientConfigRepository;
use Core\Exceptions\InvalidArgumentConfigException;
use PHPUnit\Framework\TestCase;
use Tests\Unit\Areyounormis\Mocks\ConfigMock;

class CoefficientConfigRepositoryTest extends TestCase
{
    /**
     * @group unit
     * @group areyounormis
     * @group coefficient
     * @group coefficient_config_repository
     */
    public function testGetByTypeWithInvalidArgumentConfigException(): void
    {
        self::expectException(InvalidArgumentConfigException::class);

        $classUnderTest = new CoefficientConfigRepository(new ConfigMock([], true));

        $classUnderTest->getByType('norm');
    }

    /**
     * @group unit
     * @group areyounormis
     * @group coefficient
     * @group coefficient_config_repository
     */
    public function testGetByTypeWithAnyData(): void
    {
        $configData = [
            $key1 = 'key1' => $value1 = 'value1',
            $key2 = 'key2' => [
                $key3 = 'key3' => $value3 = 'value3',
            ],
        ];
        $classUnderTest = new CoefficientConfigRepository(new ConfigMock($configData));

        $result = $classUnderTest->getByType('norm');

        self::assertEquals($value1, $result[$key1]);
        self::assertEquals($value3, $result[$key2][$key3]);
    }
}
