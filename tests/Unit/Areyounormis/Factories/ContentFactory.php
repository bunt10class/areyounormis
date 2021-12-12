<?php

declare(strict_types=1);

namespace Tests\Unit\Areyounormis\Factories;

use Areyounormis\Domain\Content\Content;

class ContentFactory
{
    public static function getItem(array $data): Content
    {
        return new Content(
            $data['ru_name'] ?? null,
            $data['en_name'] ?? null,
            $data['link'] ?? null,
        );
    }
}