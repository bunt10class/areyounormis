<?php

declare(strict_types=1);

namespace Tests\Unit\Areyounormis\Coefficient\CoefficientCalculator;

use Areyounormis\Coefficient\CoefficientCalculator;
use Areyounormis\Coefficient\Exceptions\InvalidCoefficientTypeException;
use Areyounormis\Vote\Votes;
use PHPUnit\Framework\MockObject\MockObject;

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

        $classUnderTestMock->calculateCoefficient('not_existent_type', new Votes());
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

        $classUnderTestMock->calculateCoefficient('norm', new Votes());
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

        $classUnderTestMock->calculateCoefficient('over_under_rate', new Votes());
    }

    protected function getClassUnderTestMock(): MockObject
    {
        return $this->getMockBuilder(CoefficientCalculator::class)
            ->onlyMethods(['calculateNormCoefficient', 'calculateOverUnderRateCoefficient'])
            ->getMock();
    }
}
