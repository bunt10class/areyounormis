<?php

declare(strict_types=1);

namespace Tests\Unit\Areyounormis\Service\Content;

use Areyounormis\Service\Content\ContentFacade;
use PHPUnit\Framework\TestCase;
use Tests\Unit\Areyounormis\Factories\ContentFactory;

class ContentFacadeTest extends TestCase
{
    /**
     * @group unit
     * @group areyounormis
     * @group content
     * @group content_facade
     */
    public function testCollectFullNameWithEmptyData(): void
    {
        $content = ContentFactory::getItem([]);

        $result = ContentFacade::collectFullName($content);

        self::assertEquals('Без названия', $result);
    }

    /**
     * @group unit
     * @group areyounormis
     * @group content
     * @group content_facade
     */
    public function testCollectFullNameWithOnlyRuName(): void
    {
        $content = ContentFactory::getItem(['ru_name' => $ruName = 'некоторое имя']);

        $result = ContentFacade::collectFullName($content);

        self::assertEquals($ruName, $result);
    }

    /**
     * @group unit
     * @group areyounormis
     * @group content
     * @group content_facade
     */
    public function testCollectFullNameWithOnlyEnName(): void
    {
        $content = ContentFactory::getItem(['en_name' => $enName = 'some name']);

        $result = ContentFacade::collectFullName($content);

        self::assertEquals($enName, $result);
    }

    /**
     * @group unit
     * @group areyounormis
     * @group content
     * @group content_facade
     */
    public function testCollectFullName(): void
    {
        $content = ContentFactory::getItem([
            'ru_name' => $ruName = 'некоторое имя',
            'en_name' => $enName = 'some name',
        ]);

        $result = ContentFacade::collectFullName($content);

        self::assertEquals($ruName . ' (' . $enName . ')', $result);
    }
}
