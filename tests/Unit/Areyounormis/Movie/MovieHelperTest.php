<?php

declare(strict_types=1);

namespace Tests\Unit\Areyounormis\Movie;

use Areyounormis\Movie\Movie;
use Areyounormis\Movie\MovieHelper;
use PHPUnit\Framework\TestCase;

class MovieHelperTest extends TestCase
{
    /**
     * @group unit
     * @group areyounormis
     * @group movie
     * @group movie_helper
     */
    public function testGetFullNameWithEmptyData(): void
    {
        $movie = new Movie(null, null, null);

        $result = MovieHelper::getFullName($movie);

        self::assertEquals('Без названия', $result);
    }

    /**
     * @group unit
     * @group areyounormis
     * @group movie
     * @group movie_helper
     */
    public function testGetFullNameWithOnlyRuName(): void
    {
        $ruName = 'некоторое имя';
        $movie = new Movie($ruName, null, null);

        $result = MovieHelper::getFullName($movie);

        self::assertEquals($ruName, $result);
    }

    /**
     * @group unit
     * @group areyounormis
     * @group movie
     * @group movie_helper
     */
    public function testGetFullNameWithOnlyEnName(): void
    {
        $enName = 'some name';
        $movie = new Movie(null, $enName, null);

        $result = MovieHelper::getFullName($movie);

        self::assertEquals($enName, $result);
    }

    /**
     * @group unit
     * @group areyounormis
     * @group movie
     * @group movie_helper
     */
    public function testGetFullName(): void
    {
        $ruName = 'некоторое имя';
        $enName = 'some name';
        $movie = new Movie($ruName, $enName, null);

        $result = MovieHelper::getFullName($movie);

        self::assertEquals($ruName . '(' . $enName . ')', $result);
    }
}
