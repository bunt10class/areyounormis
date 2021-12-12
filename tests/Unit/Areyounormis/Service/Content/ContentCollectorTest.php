<?php

declare(strict_types=1);

namespace Tests\Unit\Areyounormis\Service\Content;

use Areyounormis\Service\Content\ContentCollector;
use PHPUnit\Framework\TestCase;
use Tests\Unit\Areyounormis\Factories\ContentFactory;

class ContentCollectorTest extends TestCase
{
    /**
     * @group unit
     * @group areyounormis
     * @group content
     * @group content_collector
     */
    public function testGetFullNameWithEmptyData(): void
    {
        $content = ContentFactory::getItem([]);

        $result = ContentCollector::getFullName($content);

        self::assertEquals('Без названия', $result);
    }

    /**
     * @group unit
     * @group areyounormis
     * @group content
     * @group content_collector
     */
    public function testGetFullNameWithOnlyRuName(): void
    {
        $content = ContentFactory::getItem(['ru_name' => $ruName = 'некоторое имя']);

        $result = ContentCollector::getFullName($content);

        self::assertEquals($ruName, $result);
    }

    /**
     * @group unit
     * @group areyounormis
     * @group content
     * @group content_collector
     */
    public function testGetFullNameWithOnlyEnName(): void
    {
        $content = ContentFactory::getItem(['en_name' => $enName = 'some name']);

        $result = ContentCollector::getFullName($content);

        self::assertEquals($enName, $result);
    }

    /**
     * @group unit
     * @group areyounormis
     * @group content
     * @group content_collector
     */
    public function testGetFullName(): void
    {
        $content = ContentFactory::getItem([
            'ru_name' => $ruName = 'некоторое имя',
            'en_name' => $enName = 'some name',
        ]);

        $result = ContentCollector::getFullName($content);

        self::assertEquals($ruName . ' (' . $enName . ')', $result);
    }
}
