<?php

declare(strict_types=1);

namespace Tests\Unit\Areyounormis\Report\CoefficientCalculator;

class NormCoefficientCalculatorTest extends CoefficientCalculatorMain
{
    /**
     * @group unit
     * @group areyounormis
     * @group coefficient_calculator
     */
    public function testCalculateNormCoefficientWithEmptyUserRates(): void
    {
        $userRates = $this->factory->makeEmptyUserRates();

        $result = $this->classUnderTest->calculateNormCoefficient($userRates);

        self::assertEquals(1, $result);
    }

    /**
     * @group unit
     * @group areyounormis
     * @group coefficient_calculator
     */
    public function testCalculateNormCoefficientWithMaxPositiveDiff(): void
    {
        $userRates = $this->factory->makeEmptyUserRates();
        $userRates->addOne($this->factory->makeFromZeroToTenUserRate(0, 10));

        $result = $this->classUnderTest->calculateNormCoefficient($userRates);

        self::assertEquals(0, $result);
    }

    /**
     * @group unit
     * @group areyounormis
     * @group coefficient_calculator
     */
    public function testCalculateNormCoefficientWithMaxNegativeDiff(): void
    {
        $userRates = $this->factory->makeEmptyUserRates();
        $userRates->addOne($this->factory->makeFromZeroToTenUserRate(10, 0));

        $result = $this->classUnderTest->calculateNormCoefficient($userRates);

        self::assertEquals(0, $result);
    }

    /**
     * @group unit
     * @group areyounormis
     * @group coefficient_calculator
     */
    public function testCalculateNormCoefficientWithNoDiff(): void
    {
        $userRates = $this->factory->makeEmptyUserRates();
        $userRates->addOne($this->factory->makeFromZeroToTenUserRate(5, 5));

        $result = $this->classUnderTest->calculateNormCoefficient($userRates);

        self::assertEquals(1, $result);
    }

    /**
     * @group unit
     * @group areyounormis
     * @group coefficient_calculator
     */
    public function testCalculateNormCoefficientWithSomeDiffs(): void
    {
        $userRates = $this->factory->makeEmptyUserRates();
        $userRates->addOne($this->factory->makeFromZeroToTenUserRate(0, 9));
        $userRates->addOne($this->factory->makeFromZeroToTenUserRate(7, 2));
        $userRates->addOne($this->factory->makeFromZeroToTenUserRate(4, 5));

        $result = $this->classUnderTest->calculateNormCoefficient($userRates);

        self::assertEquals(0.5, $result);
    }

    /**
     * @group unit
     * @group areyounormis
     * @group coefficient_calculator
     */
    public function testCalculateNormCoefficientRightPrecision(): void
    {
        $userRates = $this->factory->makeEmptyUserRates();
        $userRates->addOne($this->factory->makeFromZeroToTenUserRate(10, 5.0001));

        $result = $this->classUnderTest->calculateNormCoefficient($userRates);

        self::assertEquals(0.5, $result);
    }
}
