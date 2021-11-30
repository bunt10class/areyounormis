<?php

declare(strict_types=1);

namespace Tests\Unit\Areyounormis\Report;

use Areyounormis\Report\CoefficientCalculator;
use Areyounormis\UserMovie\RelativeRate;
use Areyounormis\UserMovie\RelativeRates;
use PHPUnit\Framework\TestCase;

class NormCoefficientCalculatorTest extends TestCase
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
    public function testCalculateNormCoefficientWithoutRelativeRates(): void
    {
        $relativeRates = new RelativeRates();

        $result = $this->classUnderTest->calculateNormCoefficient($relativeRates);

        self::assertEquals(1, $result);
    }

    /**
     * @group unit
     * @group areyounormis
     * @group coefficient_calculator
     */
    public function testCalculateNormCoefficientWithZeroRelativeRates(): void
    {
        $relativeRates = new RelativeRates();
        $relativeRates->addOne(new RelativeRate(0));
        $relativeRates->addOne(new RelativeRate(0));

        $result = $this->classUnderTest->calculateNormCoefficient($relativeRates);

        self::assertEquals(1, $result);
    }

    /**
     * @group unit
     * @group areyounormis
     * @group coefficient_calculator
     */
    public function testCalculateNormCoefficientWithPositiveRelativeRates(): void
    {
        $relativeRates = new RelativeRates();
        $relativeRates->addOne(new RelativeRate(0.2));
        $relativeRates->addOne(new RelativeRate(0.8));

        $result = $this->classUnderTest->calculateNormCoefficient($relativeRates);

        self::assertEquals(0.5, $result);
    }

    /**
     * @group unit
     * @group areyounormis
     * @group coefficient_calculator
     */
    public function testCalculateNormCoefficientWithNegativeRelativeRates(): void
    {
        $relativeRates = new RelativeRates();
        $relativeRates->addOne(new RelativeRate(-0.4));
        $relativeRates->addOne(new RelativeRate(-0.6));

        $result = $this->classUnderTest->calculateNormCoefficient($relativeRates);

        self::assertEquals(0.5, $result);
    }

    /**
     * @group unit
     * @group areyounormis
     * @group coefficient_calculator
     */
    public function testCalculateNormCoefficientWithVariousRelativeRates(): void
    {
        $relativeRates = new RelativeRates();
        $relativeRates->addOne(new RelativeRate(0.9));
        $relativeRates->addOne(new RelativeRate(0));
        $relativeRates->addOne(new RelativeRate(-0.6));

        $result = $this->classUnderTest->calculateNormCoefficient($relativeRates);

        self::assertEquals(0.5, $result);
    }

    /**
     * @group unit
     * @group areyounormis
     * @group coefficient_calculator
     */
    public function testCalculateNormCoefficientRightPrecision(): void
    {
        $relativeRates = new RelativeRates();
        $relativeRates->addOne(new RelativeRate(0.1001));

        $result = $this->classUnderTest->calculateNormCoefficient($relativeRates);

        self::assertEquals(0.9, $result);
    }
}
