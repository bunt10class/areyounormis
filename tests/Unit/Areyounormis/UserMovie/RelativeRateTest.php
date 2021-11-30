<?php

declare(strict_types=1);

namespace Tests\Unit\Areyounormis\UserMovie;

use Areyounormis\Exceptions\RelativeRateException;
use Areyounormis\UserMovie\RelativeRate;
use PHPUnit\Framework\TestCase;

class RelativeRateTest extends TestCase
{
    /**
     * @group unit
     * @group areyounormis
     * @group relative_rate
     */
    public function testSetGetPositiveBoundaryValue(): void
    {
        $positiveBoundaryValue = 1;

        $classUnderTest = new RelativeRate($positiveBoundaryValue);

        self::assertEquals($positiveBoundaryValue, $classUnderTest->getValue());
    }

    /**
     * @group unit
     * @group areyounormis
     * @group relative_rate
     */
    public function testSetGetNegativeBoundaryValue(): void
    {
        $negativeBoundaryValue = 1;

        $classUnderTest = new RelativeRate($negativeBoundaryValue);

        self::assertEquals($negativeBoundaryValue, $classUnderTest->getValue());
    }

    /**
     * @group unit
     * @group areyounormis
     * @group relative_rate
     */
    public function testSetGetZeroValue(): void
    {
        $zeroValue = 0;

        $classUnderTest = new RelativeRate($zeroValue);

        self::assertEquals($zeroValue, $classUnderTest->getValue());
    }

    /**
     * @group unit
     * @group areyounormis
     * @group relative_rate
     */
    public function testSetAboveBoundaryValue(): void
    {
        self::expectException(RelativeRateException::class);

        new RelativeRate(1.001);
    }

    /**
     * @group unit
     * @group areyounormis
     * @group relative_rate
     */
    public function testSetBelowBoundaryValue(): void
    {
        self::expectException(RelativeRateException::class);

        new RelativeRate(-1.001);
    }

    /**
     * @group unit
     * @group areyounormis
     * @group relative_rate
     */
    public function testGetValueLikeString(): void
    {
        $value = 0.5;

        $classUnderTest = new RelativeRate($value);

        self::assertEquals((string)$value, (string)$classUnderTest);
    }

    /**
     * @group unit
     * @group areyounormis
     * @group relative_rate
     */
    public function testGetRightPrecision(): void
    {
        $classUnderTest = new RelativeRate(0.12345);

        self::assertEquals(0.123, $classUnderTest->getValue());
    }
}
