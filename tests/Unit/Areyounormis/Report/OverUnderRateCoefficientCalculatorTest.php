<?php

declare(strict_types=1);

namespace Tests\Unit\Areyounormis\Report;

use Areyounormis\Report\CoefficientCalculator;
use Areyounormis\UserMovie\RelativeRate;
use Areyounormis\UserMovie\RelativeRates;
use PHPUnit\Framework\TestCase;

class OverUnderRateCoefficientCalculatorTest extends TestCase
{
    protected CoefficientCalculator $classUnderTest;

    public function setUp(): void
    {
        parent::setUp();

        $this->classUnderTest = new CoefficientCalculator();
    }

    /**
     * @group unit
     * @group areyounormis
     * @group coefficient_calculator
     */
    public function testCalculateOverUnderRateCoefficientWithoutRelativeRates(): void
    {
        $relativeRates = new RelativeRates();

        $result = $this->classUnderTest->calculateOverUnderRateCoefficient($relativeRates);

        self::assertEquals(0, $result);
    }

    /**
     * @group unit
     * @group areyounormis
     * @group coefficient_calculator
     */
    public function testCalculateOverUnderRateCoefficientWithZeroRelativeRates(): void
    {
        $relativeRates = new RelativeRates();
        $relativeRates->addOne(new RelativeRate(0));
        $relativeRates->addOne(new RelativeRate(0));

        $result = $this->classUnderTest->calculateOverUnderRateCoefficient($relativeRates);

        self::assertEquals(0, $result);
    }

    /**
     * @group unit
     * @group areyounormis
     * @group coefficient_calculator
     */
    public function testCalculateOverUnderRateCoefficientWithPositiveRelativeRates(): void
    {
        $relativeRates = new RelativeRates();
        $relativeRates->addOne(new RelativeRate(0.2));
        $relativeRates->addOne(new RelativeRate(0.8));

        $result = $this->classUnderTest->calculateOverUnderRateCoefficient($relativeRates);

        self::assertEquals(0.5, $result);
    }

    /**
     * @group unit
     * @group areyounormis
     * @group coefficient_calculator
     */
    public function testCalculateOverUnderRateCoefficientWithNegativeRelativeRates(): void
    {
        $relativeRates = new RelativeRates();
        $relativeRates->addOne(new RelativeRate(-0.4));
        $relativeRates->addOne(new RelativeRate(-0.6));

        $result = $this->classUnderTest->calculateOverUnderRateCoefficient($relativeRates);

        self::assertEquals(-0.5, $result);
    }

    /**
     * @group unit
     * @group areyounormis
     * @group coefficient_calculator
     */
    public function testCalculateOverUnderRateCoefficientWithVariousRelativeRates(): void
    {
        $relativeRates = new RelativeRates();
        $relativeRates->addOne(new RelativeRate(0.3));
        $relativeRates->addOne(new RelativeRate(0));
        $relativeRates->addOne(new RelativeRate(-0.9));

        $result = $this->classUnderTest->calculateOverUnderRateCoefficient($relativeRates);

        self::assertEquals(-0.2, $result);
    }

    /**
     * @group unit
     * @group areyounormis
     * @group coefficient_calculator
     */
    public function testCalculateOverUnderRateCoefficientRightPrecision(): void
    {
        $relativeRates = new RelativeRates();
        $relativeRates->addOne(new RelativeRate(0.1001));

        $result = $this->classUnderTest->calculateOverUnderRateCoefficient($relativeRates);

        self::assertEquals(0.1, $result);
    }
}
