<?php

declare(strict_types=1);

namespace Tests\Unit\Areyounormis\Report\CoefficientCalculator;

class OverUnderRateCoefficientCalculatorTest extends CoefficientCalculatorMain
{
    /**
     * @group unit
     * @group areyounormis
     * @group coefficient_calculator
     */
    public function testCalculateOverUnderRateCoefficientWithEmptyUserRates(): void
    {
        $userRates = $this->factory->makeEmptyUserRates();

        $result = $this->classUnderTest->calculateOverUnderRateCoefficient($userRates);

        self::assertEquals(0, $result);
    }

    /**
     * @group unit
     * @group areyounormis
     * @group coefficient_calculator
     */
    public function testCalculateOverUnderRateCoefficientWithMaxPositiveDiff(): void
    {
        $userRates = $this->factory->makeEmptyUserRates();
        $userRates->addOne($this->factory->makeFromZeroToTenUserRate(0, 10));

        $result = $this->classUnderTest->calculateOverUnderRateCoefficient($userRates);

        self::assertEquals(1, $result);
    }

    /**
     * @group unit
     * @group areyounormis
     * @group coefficient_calculator
     */
    public function testCalculateOverUnderRateCoefficientWithMaxNegativeDiff(): void
    {
        $userRates = $this->factory->makeEmptyUserRates();
        $userRates->addOne($this->factory->makeFromZeroToTenUserRate(10, 0));

        $result = $this->classUnderTest->calculateOverUnderRateCoefficient($userRates);

        self::assertEquals(-1, $result);
    }

    /**
     * @group unit
     * @group areyounormis
     * @group coefficient_calculator
     */
    public function testCalculateOverUnderRateCoefficientWithNoDiff(): void
    {
        $userRates = $this->factory->makeEmptyUserRates();
        $userRates->addOne($this->factory->makeFromZeroToTenUserRate(5, 5));

        $result = $this->classUnderTest->calculateOverUnderRateCoefficient($userRates);

        self::assertEquals(0, $result);
    }

    /**
     * @group unit
     * @group areyounormis
     * @group coefficient_calculator
     */
    public function testCalculateOverUnderRateCoefficientWithSomeDiffs(): void
    {
        $userRates = $this->factory->makeEmptyUserRates();
        $userRates->addOne($this->factory->makeFromZeroToTenUserRate(0, 9));
        $userRates->addOne($this->factory->makeFromZeroToTenUserRate(6, 2));
        $userRates->addOne($this->factory->makeFromZeroToTenUserRate(4, 5));

        $result = $this->classUnderTest->calculateOverUnderRateCoefficient($userRates);

        self::assertEquals(0.2, $result);
    }

    /**
     * @group unit
     * @group areyounormis
     * @group coefficient_calculator
     */
    public function testCalculateOverUnderRateCoefficientRightPrecision(): void
    {
        $userRates = $this->factory->makeEmptyUserRates();
        $userRates->addOne($this->factory->makeFromZeroToTenUserRate(10, 5.0001));

        $result = $this->classUnderTest->calculateOverUnderRateCoefficient($userRates);

        self::assertEquals(-0.5, $result);
    }
}
