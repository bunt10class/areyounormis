<?php

declare(strict_types=1);

namespace Areyounormis\Service\Content;

use Areyounormis\Domain\Content\Content;

class ContentFacade
{
    protected const DEFAULT_FULL_NAME = 'Без названия';

    public static function collectFullName(Content $content): string
    {
        $enName = $content->getEnName();

        if ($ruName = $content->getRuName()) {
            $fullName = $ruName;

            if ($enName) {
                $fullName .= ' (' . $enName . ')';
            }
        } else {
            $fullName = $enName ?: self::DEFAULT_FULL_NAME;
        }

        return $fullName;
    }
}