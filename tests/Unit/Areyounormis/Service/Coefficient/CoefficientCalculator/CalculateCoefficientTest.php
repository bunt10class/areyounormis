<?php

declare(strict_types=1);

namespace Tests\Unit\Areyounormis\Service\Coefficient\CoefficientCalculator;

use Areyounormis\Service\Coefficient\CoefficientCalculator;
use Areyounormis\Service\Coefficient\Exceptions\InvalidCoefficientTypeException;
use PHPUnit\Framework\MockObject\MockObject;
use Tests\Unit\Areyounormis\Factories\VoteFactory;

class CalculateCoefficientTest extends CoefficientCalculatorMain
{
    /**
     * @group unit
     * @group areyounormis
     * @group coefficient
     * @group coefficient_calculator
     */
    public function testWithNotExistentType(): void
    {
        self::expectException(InvalidCoefficientTypeException::class);

        $classUnderTestMock = $this->getClassUnderTestMock();

        $classUnderTestMock->expects($this->never())->method('calculateNormCoefficient');
        $classUnderTestMock->expects($this->never())->method('calculateOverUnderRateCoefficient');

        $classUnderTestMock->calculateValue('not_existent_type', VoteFactory::getEmptyList());
    }

    /**
     * @group unit
     * @group areyounormis
     * @group coefficient
     * @group coefficient_calculator
     */
    public function testWithNormType(): void
    {
        $classUnderTestMock = $this->getClassUnderTestMock();

        $classUnderTestMock->expects($this->once())->method('calculateNormCoefficient');

        $classUnderTestMock->calculateValue('norm', VoteFactory::getEmptyList());
    }

    /**
     * @group unit
     * @group areyounormis
     * @group coefficient
     * @group coefficient_calculator
     */
    public function testWithUnderOverRateType(): void
    {
        $classUnderTestMock = $this->getClassUnderTestMock();

        $classUnderTestMock->expects($this->once())->method('calculateOverUnderRateCoefficient');

        $classUnderTestMock->calculateValue('over_under_rate', VoteFactory::getEmptyList());
    }

    protected function getClassUnderTestMock(): MockObject
    {
        return $this->getMockBuilder(CoefficientCalculator::class)
            ->onlyMethods(['calculateNormCoefficient', 'calculateOverUnderRateCoefficient'])
            ->getMock();
    }
}
