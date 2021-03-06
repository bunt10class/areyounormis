<?php

declare(strict_types=1);

namespace Tests\Unit\Areyounormis\Infrastructure\ResourceData;

use Areyounormis\Infrastructure\ResourceData\KinopoiskDataRepository;
use Kinopoisk\Dto\KinopoiskUserMovieList;
use PHPUnit\Framework\TestCase;
use Tests\Unit\Areyounormis\Mocks\KinopoiskUserMovieServiceMock;
use Tests\Unit\Kinopoisk\Factories\KinopoiskUserMovieFactory;

class KinopoiskDataRepositoryTest extends TestCase
{
    protected KinopoiskUserMovieFactory $factory;

    public function setUp(): void
    {
        parent::setUp();

        $this->factory = new KinopoiskUserMovieFactory();
    }

    /**
     * @group unit
     * @group areyounormis
     * @group site_data
     * @group kinopoisk_site_data_factory
     */
    public function testMakeByUserIdFromKinopoisk(): void
    {
        $userMovies = $this->factory->makeListWithOne([
            'ru_name' => $ruName = 'некоторое имя',
            'en_name' => $enName = 'some name',
            'link' => $link = '/some_url',
            'kp_vote' => $kpVote = 2.5,
            'user_vote' => $userVote = 7,
        ]);
        $classUnderTest = $this->makeClassUnderTest($userMovies);

        $result = $classUnderTest->getByUserId('some_user_id');

        self::assertEquals(10, $result->getVoteSystem()->getMax());
        self::assertEquals(1, $result->getVoteSystem()->getMin());
        self::assertEquals(1, $result->getVoteSystem()->getStep());
        
        self::assertEquals($userVote, $result->getVoteList()->getItems()[0]->getUserVote());
        self::assertEquals($kpVote, $result->getVoteList()->getItems()[0]->getResourceVote());
        
        self::assertEquals($userVote, $result->getContentVoteList()->getItems()[0]->getVote()->getUserVote());
        self::assertEquals($kpVote, $result->getContentVoteList()->getItems()[0]->getVote()->getResourceVote());
        self::assertEquals($ruName, $result->getContentVoteList()->getItems()[0]->getContent()->getRuName());
        self::assertEquals($enName, $result->getContentVoteList()->getItems()[0]->getContent()->getEnName());
        self::assertEquals('https://www.kinopoisk.ru' . $link, $result->getContentVoteList()->getItems()[0]->getContent()->getLink());
    }

    /**
     * @group unit
     * @group areyounormis
     * @group site_data
     * @group kinopoisk_site_data_factory
     */
    public function testMakeByUserIdFromKinopoiskWithKpVoteNull(): void
    {
        $userMovies = $this->factory->makeListWithOne([
            'kp_vote' => null,
            'user_vote' => 7,
        ]);
        $classUnderTest = $this->makeClassUnderTest($userMovies);

        $result = $classUnderTest->getByUserId('some_user_id');

        self::assertEmpty($result->getVoteList()->getItems());
        self::assertEmpty($result->getContentVoteList()->getItems());
    }

    /**
     * @group unit
     * @group areyounormis
     * @group site_data
     * @group kinopoisk_site_data_factory
     */
    public function testMakeByUserIdFromKinopoiskWithKpVoteMoreThanMax(): void
    {
        $userMovies = $this->factory->makeListWithOne([
            'kp_vote' => 10.1,
            'user_vote' => 7,
        ]);
        $classUnderTest = $this->makeClassUnderTest($userMovies);

        $result = $classUnderTest->getByUserId('some_user_id');

        self::assertEmpty($result->getVoteList()->getItems());
        self::assertEmpty($result->getContentVoteList()->getItems());
    }

    /**
     * @group unit
     * @group areyounormis
     * @group site_data
     * @group kinopoisk_site_data_factory
     */
    public function testMakeByUserIdFromKinopoiskWithKpVoteLessThanMin(): void
    {
        $userMovies = $this->factory->makeListWithOne([
            'kp_vote' => 0.9,
            'user_vote' => 7,
        ]);
        $classUnderTest = $this->makeClassUnderTest($userMovies);

        $result = $classUnderTest->getByUserId('some_user_id');

        self::assertEmpty($result->getVoteList()->getItems());
        self::assertEmpty($result->getContentVoteList()->getItems());
    }

    /**
     * @group unit
     * @group areyounormis
     * @group site_data
     * @group kinopoisk_site_data_factory
     */
    public function testMakeByUserIdFromKinopoiskWithUserVoteNull(): void
    {
        $userMovies = $this->factory->makeListWithOne([
            'kp_vote' => 2.5,
            'user_vote' => null,
        ]);
        $classUnderTest = $this->makeClassUnderTest($userMovies);

        $result = $classUnderTest->getByUserId('some_user_id');

        self::assertEmpty($result->getVoteList()->getItems());
        self::assertEmpty($result->getContentVoteList()->getItems());
    }

    /**
     * @group unit
     * @group areyounormis
     * @group site_data
     * @group kinopoisk_site_data_factory
     */
    public function testMakeByUserIdFromKinopoiskWithUserVoteMoreThanMax(): void
    {
        $userMovies = $this->factory->makeListWithOne([
            'kp_vote' => 2.5,
            'user_vote' => 11,
        ]);
        $classUnderTest = $this->makeClassUnderTest($userMovies);

        $result = $classUnderTest->getByUserId('some_user_id');

        self::assertEmpty($result->getVoteList()->getItems());
        self::assertEmpty($result->getContentVoteList()->getItems());
    }

    /**
     * @group unit
     * @group areyounormis
     * @group site_data
     * @group kinopoisk_site_data_factory
     */
    public function testMakeByUserIdFromKinopoiskWithUserVoteLessThanMin(): void
    {
        $userMovies = $this->factory->makeListWithOne([
            'kp_vote' => 2.5,
            'user_vote' => 0,
        ]);
        $classUnderTest = $this->makeClassUnderTest($userMovies);

        $result = $classUnderTest->getByUserId('some_user_id');

        self::assertEmpty($result->getVoteList()->getItems());
        self::assertEmpty($result->getContentVoteList()->getItems());
    }

    protected function makeClassUnderTest(KinopoiskUserMovieList $userMovies): KinopoiskDataRepository
    {
        return new KinopoiskDataRepository(new KinopoiskUserMovieServiceMock($userMovies));
    }
}
