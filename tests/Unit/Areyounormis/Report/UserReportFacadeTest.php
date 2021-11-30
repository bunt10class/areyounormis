<?php

declare(strict_types=1);

namespace Tests\Unit\Areyounormis\Report;

use Areyounormis\Report\UserReportFacade;
use PHPUnit\Framework\TestCase;
use Tests\Unit\Areyounormis\Factories\UserMovieRateFactory;
use Tests\Unit\Areyounormis\Factories\UserReportFactory;

class UserReportFacadeTest extends TestCase
{
    protected UserReportFactory $factory;
    protected UserMovieRateFactory $userMovieRateFactory;

    public function setUp(): void
    {
        parent::setUp();

        $this->factory = new UserReportFactory();

        $this->userMovieRateFactory = new UserMovieRateFactory();
    }

    /**
     * @group unit
     * @group areyounormis
     * @group user_report_facade
     */
    public function testToArrayGetValidStructure(): void
    {
        $userReport = $this->factory->makeUserReport();

        $classUnderTest = new UserReportFacade($userReport);

        $result = $classUnderTest->getPrettyData();

        self::assertArrayHasKey('user', $result);
        $user = $result['user'];
        self::assertIsArray($user);
        self::assertArrayHasKey('id', $user);
        self::assertArrayHasKey('login', $user);

        self::assertArrayHasKey('norm_coefficient', $result);
        self::assertArrayHasKey('over_under_rate_coefficient', $user);

        self::assertUserMovieRatesHasValidStructure('over_rates', $result);
        self::assertUserMovieRatesHasValidStructure('norm_rates', $result);
        self::assertUserMovieRatesHasValidStructure('under_rates', $result);
    }

    protected static function assertUserMovieRatesHasValidStructure(string $type, array $result): void
    {
        self::assertArrayHasKey($type, $result);
        $userMovieRates = $result[$type];
        self::assertIsArray($userMovieRates);
        $userMovieRate = $userMovieRates[0];
        self::assertIsArray($userMovieRate);
        self::assertArrayHasKey('relative_rate', $userMovieRate);
        self::assertArrayHasKey('user_vote', $userMovieRate);
        self::assertArrayHasKey('vote', $userMovieRate);
        self::assertArrayHasKey('name', $userMovieRate);
        self::assertArrayHasKey('link', $userMovieRate);
    }

    /**
     * @group unit
     * @group areyounormis
     * @group user_report_facade
     */
    public function testToArrayGetRightUserAndCoefficientData(): void
    {
        $userId = 123;
        $userLogin = 'some_login';
        $normCoefficient = 0.456;
        $overUnderRateCoefficient = -0.789;
        $userReport = $this->factory->makeUserReport([
            'user_id' => $userId,
            'user_login' => $userLogin,
            'norm_coefficient' => $normCoefficient,
            'over_under_rate_coefficient' => $overUnderRateCoefficient,
        ]);
        $classUnderTest = new UserReportFacade($userReport);

        $result = $classUnderTest->getPrettyData();

        self::assertEquals($userId, $result['user']['id']);
        self::assertEquals($userId, $result['user']['id']);
        self::assertEquals($normCoefficient, $result['norm_coefficient']);
        self::assertEquals($overUnderRateCoefficient, $result['over_under_rate_coefficient']);
    }

    /**
     * @group unit
     * @group areyounormis
     * @group user_report_facade
     */
    public function testToArrayGetRightNumberUserMovieRates(): void
    {
        $overRates = $this->userMovieRateFactory->makeUserMovieRatesWithChildren($overRateNumber = 2);
        $normRates = $this->userMovieRateFactory->makeUserMovieRatesWithChildren($normRateNumber = 3);
        $underRates = $this->userMovieRateFactory->makeUserMovieRatesWithChildren($underRateNumber = 4);
        $userReport = $this->factory->makeUserReport([
            'over_rates' => $overRates,
            'norm_rates' => $normRates,
            'under_rates' => $underRates,
        ]);
        $classUnderTest = new UserReportFacade($userReport);

        $result = $classUnderTest->getPrettyData();

        self::assertCount($overRateNumber, $result['over_rates']);
        self::assertCount($normRateNumber, $result['norm_rates']);
        self::assertCount($underRateNumber, $result['under_rates']);
    }

    /**
     * @group unit
     * @group areyounormis
     * @group user_report_facade
     */
    public function testToArrayGetRightOverRatesData(): void
    {
        $this->testToArrayRightUserMovieRatesData('over_rates');
    }

    /**
     * @group unit
     * @group areyounormis
     * @group user_report_facade
     */
    public function testToArrayGetRightNormRatesData(): void
    {
        $this->testToArrayRightUserMovieRatesData('norm_rates');
    }

    /**
     * @group unit
     * @group areyounormis
     * @group user_report_facade
     */
    public function testToArrayGetRightUnderRatesData(): void
    {
        $this->testToArrayRightUserMovieRatesData('under_rates');
    }

    protected function testToArrayRightUserMovieRatesData($type): void
    {
        $ruName = 'некоторое имя';
        $enName = 'some name';
        $link = 'https://some_url';
        $vote = 'some_vote';
        $userVote = 'some_user_vote';
        $relatedRate = 0.1;
        $userMovieRates = $this->userMovieRateFactory->makeEmptyUserMovieRates();
        $userMovieRates->addOne($this->userMovieRateFactory->makeUserMovieRate([
            'ru_name' => $ruName,
            'en_name' => $enName,
            'link' => $link,
            'vote' => $vote,
            'user_vote' => $userVote,
            'relative_rate' => $relatedRate,
        ]));
        $userReport = $this->factory->makeUserReport([
            $type => $userMovieRates,
        ]);

        $classUnderTest = new UserReportFacade($userReport);

        $result = $classUnderTest->getPrettyData();
        $userMovieRateData = $result[$type][0];
        self::assertEquals($ruName, $userMovieRateData['ru_name']);
        self::assertEquals($enName, $userMovieRateData['en_name']);
        self::assertEquals($link, $userMovieRateData['link']);
        self::assertEquals($vote, $userMovieRateData['vote']);
        self::assertEquals($userVote, $userMovieRateData['user_vote']);
        self::assertEquals($relatedRate, $userMovieRateData['relative_rate']);
    }
}
