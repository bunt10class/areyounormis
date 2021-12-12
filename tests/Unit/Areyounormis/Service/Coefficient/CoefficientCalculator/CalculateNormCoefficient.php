<?php

declare(strict_types=1);

namespace Tests\Unit\Areyounormis\Service\Coefficient\CoefficientCalculator;

use Tests\Unit\Areyounormis\Factories\VoteFactory;

class CalculateNormCoefficient extends CoefficientCalculatorMain
{
    /**
     * @group unit
     * @group areyounormis
     * @group coefficient
     * @group coefficient_calculator
     */
    public function testWithEmptyVotes(): void
    {
        $votes = VoteFactory::getEmptyList();

        $result = $this->classUnderTest->calculateNormCoefficient($votes);

        self::assertEquals(1, $result);
    }

    /**
     * @group unit
     * @group areyounormis
     * @group coefficient
     * @group coefficient_calculator
     */
    public function testUserVoteEqualsSiteVote(): void
    {
        $votes = VoteFactory::getListWithOneDefaultItem(5, 5);

        $result = $this->classUnderTest->calculateNormCoefficient($votes);

        self::assertEquals(1, $result);
    }

    /**
     * @group unit
     * @group areyounormis
     * @group coefficient
     * @group coefficient_calculator
     */
    public function testUserVoteMoreThanSiteVote(): void
    {
        $votes = VoteFactory::getListWithOneDefaultItem(7, 2);

        $result = $this->classUnderTest->calculateNormCoefficient($votes);

        self::assertEquals(0.5, $result);
    }

    /**
     * @group unit
     * @group areyounormis
     * @group coefficient
     * @group coefficient_calculator
     */
    public function testUserVoteLessThanSiteVote(): void
    {
        $votes = VoteFactory::getListWithOneDefaultItem(2, 7);

        $result = $this->classUnderTest->calculateNormCoefficient($votes);

        self::assertEquals(0.5, $result);
    }

    /**
     * @group unit
     * @group areyounormis
     * @group coefficient
     * @group coefficient_calculator
     */
    public function testFloatUserVoteAndSiteVote(): void
    {
        $votes = VoteFactory::getListWithOneDefaultItem(7.1, 2.1);

        $result = $this->classUnderTest->calculateNormCoefficient($votes);

        self::assertEquals(0.5, $result);
    }

    /**
     * @group unit
     * @group areyounormis
     * @group coefficient
     * @group coefficient_calculator
     */
    public function testWith3Votes(): void
    {
        $votes = VoteFactory::getEmptyList();
        $votes->addItem(VoteFactory::getDefaultItem(1, 9));
        $votes->addItem(VoteFactory::getDefaultItem(8, 2));
        $votes->addItem(VoteFactory::getDefaultItem(3, 7));

        $result = $this->classUnderTest->calculateNormCoefficient($votes);

        self::assertEquals(0.6, $result);
    }

    /**
     * @group unit
     * @group areyounormis
     * @group coefficient
     * @group coefficient_calculator
     */
    public function testRightPrecision(): void
    {
        $votes = VoteFactory::getListWithOneDefaultItem( 7.0001, 2);

        $result = $this->classUnderTest->calculateNormCoefficient($votes);

        self::assertEquals(0.5, $result);
    }
}
