<?php

declare(strict_types=1);

namespace Tests\Unit\Areyounormis\Coefficient\CoefficientCalculator;

use Areyounormis\Vote\VoteFactory;
use Areyounormis\Vote\Votes;

class CalculateOverUnderRateCoefficient extends CoefficientCalculatorMain
{
    /**
     * @group unit
     * @group areyounormis
     * @group coefficient
     * @group coefficient_calculator
     */
    public function testWithEmptyVotes(): void
    {
        $votes = new Votes();

        $result = $this->classUnderTest->calculateOverUnderRateCoefficient($votes);

        self::assertEquals(0, $result);
    }

    /**
     * @group unit
     * @group areyounormis
     * @group coefficient
     * @group coefficient_calculator
     */
    public function testUserVoteEqualsSiteVote(): void
    {
        $votes = new Votes();
        $votes->addItem(VoteFactory::make($this->makeTenZeroOneVoteSystem(), 5, 5));

        $result = $this->classUnderTest->calculateOverUnderRateCoefficient($votes);

        self::assertEquals(0, $result);
    }

    /**
     * @group unit
     * @group areyounormis
     * @group coefficient
     * @group coefficient_calculator
     */
    public function testUserVoteMoreThanSiteVote(): void
    {
        $votes = new Votes();
        $votes->addItem(VoteFactory::make($this->makeTenZeroOneVoteSystem(), 7, 2));

        $result = $this->classUnderTest->calculateOverUnderRateCoefficient($votes);

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
        $votes = new Votes();
        $votes->addItem(VoteFactory::make($this->makeTenZeroOneVoteSystem(), 2, 7));

        $result = $this->classUnderTest->calculateOverUnderRateCoefficient($votes);

        self::assertEquals(-0.5, $result);
    }

    /**
     * @group unit
     * @group areyounormis
     * @group coefficient
     * @group coefficient_calculator
     */
    public function testFloatUserVoteAndSiteVote(): void
    {
        $votes = new Votes();
        $votes->addItem(VoteFactory::make($this->makeTenZeroOneVoteSystem(), 7.1, 2.1));

        $result = $this->classUnderTest->calculateOverUnderRateCoefficient($votes);

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
        $votes = new Votes();
        $votes->addItem(VoteFactory::make($this->makeTenZeroOneVoteSystem(), 1, 9));
        $votes->addItem(VoteFactory::make($this->makeTenZeroOneVoteSystem(), 8, 2));
        $votes->addItem(VoteFactory::make($this->makeTenZeroOneVoteSystem(), 3, 7));

        $result = $this->classUnderTest->calculateOverUnderRateCoefficient($votes);

        self::assertEquals(0.2, $result);
    }

    /**
     * @group unit
     * @group areyounormis
     * @group coefficient
     * @group coefficient_calculator
     */
    public function testRightPrecision(): void
    {
        $votes = new Votes();
        $votes->addItem(VoteFactory::make($this->makeTenZeroOneVoteSystem(), 2.0001, 7));

        $result = $this->classUnderTest->calculateOverUnderRateCoefficient($votes);

        self::assertEquals(-0.5, $result);
    }
}
